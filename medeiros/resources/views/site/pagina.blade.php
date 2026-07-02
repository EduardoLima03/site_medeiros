@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <a href="{{ url('/') }}" class="text-muted text-decoration-none">&larr; Voltar</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="mb-4" style="color: var(--text-green); font-weight: 700;">
                    {{ $contents['titulo']->content ?? $slug }}
                </h2>

                @foreach($contents as $section => $content)
                @if($section !== 'titulo')
                <div class="mb-4">
                    {!! $content->content !!}
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection