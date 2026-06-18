@extends('layouts.dashboard')

@section('content')
<h2 class="mb-4" style="font-weight: 700;">Painel Marketing</h2>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-dashboard border-start border-success border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">Ofertas Ativas</h5>
                <h2 class="fw-bold text-success">{{ $ofertasAtivas }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-dashboard border-start border-info border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">Total de Ofertas</h5>
                <h2 class="fw-bold text-info">{{ $totalOfertas }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="mt-4">
    <a href="{{ route('marketing.ofertas') }}" class="btn btn-success rounded-pill px-4"><i class="bi bi-tag"></i> Gerenciar Ofertas</a>
</div>
@endsection
