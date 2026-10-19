@extends('templates.home')
            @section('title', 'Precificação de Produtos')

{{-- CDN do Bootstrap deve ser carregada no templates.home, mas mantive aqui por segurança --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
{{-- Ícones do Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@section('content')
<div class="container my-5">
    
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">Escolha o Plano Ideal para Você</h1>
        <p class="lead text-muted">Conteúdo exclusivo, análises aprofundadas e acesso instantâneo.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        {{-- Itera sobre a variável $plans, que deve ser passada pelo HomeController --}}
        @forelse ($plans as $plan) 
        <div class="col">
            <div class="card h-100 shadow-lg border-0 border-top border-4 border-primary">
                <div class="card-body p-4 text-center">
                    <h2 class="card-title h3 fw-bold">{{ $plan->name }}</h2>
                    <p class="text-muted text-uppercase mb-4">{{ $plan->duration_days }} Dias de Acesso</p>
                    
                    <div class="my-4">
                        <span class="fs-1 fw-bolder text-dark">R$ {{ number_format($plan->price, 0, ',', '.') }}</span>
                        {{-- Exibe os centavos após a vírgula --}}
                        <span class="fs-4 fw-normal text-muted">,{{ str_pad(explode('.', number_format($plan->price, 2, '.', ''))[1], 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <ul class="list-unstyled text-start mx-auto mb-4" style="max-width: 250px;">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Acesso a todo o conteúdo premium.</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Suporte prioritário por e-mail.</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Atualizações diárias de conteúdo.</li>
                        @if ($plan->duration_days > 30)
                           <li class="mb-2 text-success fw-bold"><i class="bi bi-star-fill text-success me-2"></i> Bônus de fidelidade incluído.</li>
                        @endif
                    </ul>
                    
                    {{-- CORRIGIDO: Passando o modelo $plan diretamente para a rota 'payment.show'. --}}
                    <a href="{{ route('payment.show', $plan) }}" 
                        class="btn btn-primary btn-lg w-100 mt-auto">
                        Assinar Agora
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center" role="alert">
                Nenhum plano de assinatura encontrado. Por favor, adicione planos via Tinker.
            </div>
        </div>
        @endforelse
    </div>
    </div>
    @endsection