<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Currículo - {{ $curriculo->nome }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; max-width: 800px; margin: 0 auto; }
        h1 { color: #333; border-bottom: 2px solid #387543; padding-bottom: 0.5rem; font-size: 1.8rem; }
        h2 { color: #387543; font-size: 1.2rem; margin-top: 1.5rem; border-bottom: 1px solid #ccc; padding-bottom: 0.3rem; }
        .info { margin: 1rem 0; }
        .info p { margin: 0.3rem 0; }
        .label { font-weight: bold; color: #555; display: inline-block; min-width: 120px; }
        .section { margin: 0.5rem 0 1rem; white-space: pre-wrap; line-height: 1.6; }
    </style>
</head>
<body>
    <h1>Currículo</h1>
    <div class="info">
        <p><span class="label">Nome:</span> {{ $curriculo->nome }}</p>
        <p><span class="label">E-mail:</span> {{ $curriculo->email }}</p>
        <p><span class="label">Telefone:</span> {{ $curriculo->telefone }}</p>
        <p><span class="label">Endereço:</span> {{ $curriculo->endereco ?? '-' }}</p>
        <p><span class="label">Idade:</span> {{ $curriculo->idade ?? '-' }}</p>
        <p><span class="label">Sexo:</span> {{ $curriculo->sexo ?? '-' }}</p>
        <p><span class="label">Família:</span> {{ $curriculo->familia ?? '-' }}</p>
        <p><span class="label">Cadastrado em:</span> {{ $curriculo->created_at->format('d/m/Y H:i') }}</p>
    </div>

    @if($curriculo->objetivo)
    <h2>Objetivo Profissional</h2>
    <div class="section">{{ $curriculo->objetivo }}</div>
    @endif

    @if($curriculo->formacao)
    <h2>Formação Acadêmica</h2>
    <div class="section">{{ $curriculo->formacao }}</div>
    @endif

    @if($curriculo->experiencia_profissional)
    <h2>Experiência Profissional</h2>
    <div class="section">{{ $curriculo->experiencia_profissional }}</div>
    @endif

    @if($curriculo->observacao)
    <h2>Observação</h2>
    <div class="section">{{ $curriculo->observacao }}</div>
    @endif

    @if($curriculo->arquivo)
    <p style="margin-top: 2rem;">Currículo em anexo: <a href="{{ route('rh.curriculos.download', $curriculo) }}">Download PDF</a></p>
    @endif
    <script>window.print();</script>
</body>
</html>
