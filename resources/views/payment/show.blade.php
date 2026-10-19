@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Finalizar pagamento</h2>

    <p>
        Plano escolhido:
        <strong>{{ $plan->name }}</strong>
    </p>

    <form method="POST" action="{{ route('payment.process') }}">
        @csrf

        <input type="hidden" name="plan_id" value="{{ $plan->id }}">

        <div class="mb-3">
            <label class="form-label">Forma de pagamento</label>
            <select name="payment_method" class="form-select" required>
                <option value="credit_card">Cartão de Crédito</option>
                <option value="pix">PIX</option>
                <option value="boleto">Boleto</option>
            </select>
        </div>

        <button class="btn btn-success">
            Pagar e continuar
        </button>
    </form>
</div>
@endsection
