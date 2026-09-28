/**
 * Geração de thumbnails de PDF no navegador (PDF.js via CDN).
 *
 * Hospedagens compartilhadas costumam bloquear exec(), então o PHP não consegue
 * rasterizar o PDF. Aqui a 1ª página é renderizada no navegador e o JPEG
 * resultante é enviado ao servidor.
 */
(function () {
    'use strict';

    var PDFJS_BASE = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@4.10.38/';
    var LARGURA_THUMB = 800;
    var QUALIDADE = 0.85;

    var pdfjs = null;

    function carregarPdfJs() {
        if (!pdfjs) {
            pdfjs = import(PDFJS_BASE + 'build/pdf.min.mjs')
                .then(function (lib) {
                    lib.GlobalWorkerOptions.workerSrc = PDFJS_BASE + 'build/pdf.worker.min.mjs';
                    return lib;
                })
                .catch(function (erro) {
                    pdfjs = null;
                    throw erro;
                });
        }

        return pdfjs;
    }

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function ehPdf(arquivo) {
        return !!arquivo && (arquivo.type === 'application/pdf' || /\.pdf$/i.test(arquivo.name));
    }

    function renderizarPrimeiraPagina(fonte) {
        return carregarPdfJs()
            .then(function (lib) {
                return lib
                    .getDocument({
                        url: fonte.url || null,
                        data: fonte.data || null,
                        cMapUrl: PDFJS_BASE + 'cmaps/',
                        cMapPacked: true,
                        standardFontDataUrl: PDFJS_BASE + 'standard_fonts/',
                    })
                    .promise;
            })
            .then(function (doc) {
                return doc.getPage(1).then(function (pagina) {
                    var original = pagina.getViewport({ scale: 1 });
                    var viewport = pagina.getViewport({ scale: LARGURA_THUMB / original.width });
                    var canvas = document.createElement('canvas');

                    canvas.width = Math.max(1, Math.floor(viewport.width));
                    canvas.height = Math.max(1, Math.floor(viewport.height));

                    var ctx = canvas.getContext('2d');
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    return pagina
                        .render({ canvasContext: ctx, viewport: viewport })
                        .promise.then(function () {
                            return new Promise(function (resolve, reject) {
                                canvas.toBlob(function (blob) {
                                    if (blob) {
                                        resolve(blob);
                                    } else {
                                        reject(new Error('O navegador nao conseguiu gerar a imagem.'));
                                    }
                                }, 'image/jpeg', QUALIDADE);
                            });
                        });
                }).finally(function () {
                    return doc.destroy();
                });
            });
    }

    function enviarThumb(url, blob) {
        var dados = new FormData();
        dados.append('thumb', blob, 'thumb.jpg');

        return fetch(url, {
            method: 'POST',
            body: dados,
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
            },
        }).then(function (resposta) {
            if (!resposta.ok) {
                throw new Error('Falha ao salvar a thumbnail (HTTP ' + resposta.status + ').');
            }

            return resposta;
        });
    }

    function spinner(texto) {
        return '<span class="spinner-border spinner-border-sm me-1"></span>' + texto;
    }

    /* ------------------------------------------------------------------ */
    /* Painel de ofertas: botão por card + botão "Gerar thumbnails"        */
    /* ------------------------------------------------------------------ */

    function gerarCard(card) {
        return renderizarPrimeiraPagina({ url: card.getAttribute('data-pdf-url') }).then(function (blob) {
            return enviarThumb(card.getAttribute('data-thumb-url'), blob).then(function () {
                var img = card.querySelector('[data-thumb-img]');

                if (img) {
                    img.src = URL.createObjectURL(blob);
                }
            });
        });
    }

    function painel() {
        var lista = document.querySelectorAll('[data-sem-thumb="1"]');
        var botaoTodas = document.getElementById('btnGerarThumbs');

        if (!lista.length) {
            return;
        }

        Array.prototype.forEach.call(lista, function (card) {
            var botao = card.querySelector('.js-gerar-thumb');

            if (!botao) {
                return;
            }

            botao.addEventListener('click', function () {
                botao.disabled = true;
                botao.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                gerarCard(card)
                    .then(function () {
                        botao.remove();
                    })
                    .catch(function (erro) {
                        botao.disabled = false;
                        botao.innerHTML = '<i class="bi bi-image"></i>';
                        window.alert('Não foi possível gerar a thumbnail de "' + card.getAttribute('data-titulo') + '".\n\n' + erro.message);
                    });
            });
        });

        if (!botaoTodas) {
            return;
        }

        botaoTodas.addEventListener('click', function () {
            botaoTodas.disabled = true;
            var total = lista.length;
            var indice = 0;

            var proximo = function () {
                indice += 1;

                if (indice > total) {
                    window.location.reload();
                    return Promise.resolve();
                }

                var card = lista[indice - 1];
                var botao = card.querySelector('.js-gerar-thumb');

                card.setAttribute('data-sem-thumb', '0');

                if (botao) {
                    botao.disabled = true;
                }

                botaoTodas.innerHTML = spinner('Gerando ' + indice + ' de ' + total);

                return gerarCard(card)
                    .catch(function (erro) {
                        card.setAttribute('data-sem-thumb', '1');
                        console.warn('Thumbnail não gerado: ' + card.getAttribute('data-titulo'), erro);
                    })
                    .then(proximo);
            };

            proximo();
        });
    }

    /* ------------------------------------------------------------------ */
    /* Formulário de oferta: gera a thumbnail junto com o PDF selecionado  */
    /* ------------------------------------------------------------------ */

    function formulario() {
        var form = document.getElementById('ofertaForm');

        if (!form) {
            return;
        }

        var inputArquivo = document.getElementById('arquivoInput');
        var box = document.getElementById('thumbBox');
        var preview = document.getElementById('thumbPreview');
        var aviso = document.getElementById('thumbAviso');
        var alertas = document.getElementById('ofertaAlertas');
        var botao = form.querySelector('button[type="submit"]');
        var thumb = null;

        var limpar = function () {
            thumb = null;

            if (preview) {
                preview.removeAttribute('src');
            }
        };

        inputArquivo.addEventListener('change', function () {
            var arquivo = inputArquivo.files[0];
            limpar();

            if (!ehPdf(arquivo)) {
                box.hidden = true;
                return;
            }

            box.hidden = false;
            preview.hidden = true;
            aviso.innerHTML = spinner('Gerando a 1ª página do PDF...');

            arquivo
                .arrayBuffer()
                .then(function (buffer) {
                    return renderizarPrimeiraPagina({ data: new Uint8Array(buffer) });
                })
                .then(function (blob) {
                    thumb = blob;
                    preview.src = URL.createObjectURL(blob);
                    preview.hidden = false;
                    aviso.textContent = 'Thumbnail gerada. Ela será salva junto com a oferta.';
                })
                .catch(function () {
                    thumb = null;
                    aviso.textContent = 'Não foi possível gerar a thumbnail deste PDF. A oferta será salva mesmo assim.';
                });
        });

        form.addEventListener('submit', function (evento) {
            // Sem thumbnail gerada (imagem, PDF sem preview ou JS indisponível): submit normal.
            if (!thumb) {
                return;
            }

            evento.preventDefault();

            var dados = new FormData(form);
            dados.set('thumb', thumb, 'thumb.jpg');

            botao.disabled = true;
            botao.innerHTML = spinner('Salvando...');

            fetch(form.action, {
                method: 'POST',
                body: dados,
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    Accept: 'application/json',
                },
            })
                .then(function (resposta) {
                    return resposta.json().catch(function () {
                        return {};
                    }).then(function (json) {
                        return { status: resposta.status, json: json };
                    });
                })
                .then(function (r) {
                    if (r.status >= 200 && r.status < 300) {
                        window.location.assign(r.json.redirect || form.action);
                        return;
                    }

                    botao.disabled = false;
                    botao.innerHTML = 'Salvar';

                    var mensagens = r.json.errors ? Object.values(r.json.errors).flat() : [r.json.message || 'Falha ao salvar a oferta.'];
                    alertas.innerHTML = '<div class="alert alert-danger">' + mensagens.join('<br>') + '</div>';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(function () {
                    botao.disabled = false;
                    botao.innerHTML = 'Salvar';
                    form.submit();
                });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        painel();
        formulario();
    });
})();
