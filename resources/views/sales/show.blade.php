@extends('layouts.app')

@section('title', 'Detalhes da venda')

@section('content_header')
    <h1>Detalhes da venda #{{ $sale->id }}</h1>
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informações gerais</h3>
                </div>
                <div class="card-body">
                    <p><strong>Data:</strong> {{ $sale->sale_date?->format('d/m/Y H:i') ?? $sale->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Vendedor:</strong> {{ $sale->seller?->name ?? '-' }}</p>
                    <p><strong>Cliente:</strong> {{ $sale->customer_name ?: '-' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Totais</h3>
                </div>
                <div class="card-body">
                    <p class="d-flex justify-content-between mb-1">
                        <span>Subtotal</span>
                        <span>R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</span>
                    </p>
                    <p class="d-flex justify-content-between mb-1">
                        <span>Desconto</span>
                        <span>
                            @if($sale->discount_percent > 0)
                                {{ number_format($sale->discount_percent, 2, ',', '.') }}%
                                (R$ {{ number_format($sale->discount_amount, 2, ',', '.') }})
                            @else
                                R$ 0,00
                            @endif
                        </span>
                    </p>
                    <p class="d-flex justify-content-between font-weight-bold border-top pt-2 mt-2">
                        <span>Total</span>
                        <span>R$ {{ number_format($sale->total, 2, ',', '.') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Itens da venda</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap mb-0">
                <thead>
                <tr>
                    <th>Material</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Valor unitário (R$)</th>
                    <th class="text-right">Total (R$)</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sale->items as $item)
                    <tr>
                        <td>
                            <div class="font-weight-bold">{{ $item->material->name }}</div>
                            <div class="text-muted small">{{ $item->material->unit }}</div>
                        </td>
                        <td class="text-right">
                            {{ number_format($item->quantity, 3, ',', '.') }} {{ $item->material->unit }}
                        </td>
                        <td class="text-right">
                            R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                        </td>
                        <td class="text-right">
                            R$ {{ number_format($item->total, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('sales.index') }}" class="btn btn-default">
            Voltar para lista de vendas
        </a>
    </div>
@endsection
