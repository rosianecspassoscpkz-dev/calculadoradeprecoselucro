@extends('templates.home')

@section('title', 'Precificação de Produtos')

@section('content')
<div class="container my-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Escolha o Plano Ideal</h1>
        <p class="lead text-muted">Conteúdo exclusivo e acesso instantâneo.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($plans as $plan)
            <div class="col">
                <div class="card h-100 shadow border-0 border-top border-4 border-primary">
                    <div class="card-body text-center">
                        <h3 class="fw-bold">{{ $plan->name }}</h3>
                        <p class="text-muted">{{ $plan->duration_days }} dias</p>

                        <h2 class="fw-bolder">R$ {{ number_format($plan->price, 2, ',', '.') }}</h2>

                        <a href="{{ route('payment.show', $plan) }}"
                           class="btn btn-primary w-100 mt-3">
                            Assinar agora
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                Nenhum plano encontrado.
            </div>
        @endforelse
    </div>
</div>
@endsection
