@extends('layouts.app')

@section('title', 'Detalhes da venda')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Detalhes da venda #{{ $sale->id }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-sm font-semibold mb-2">Informações gerais</h2>
            <p class="text-sm"><strong>Data:</strong> {{ $sale->sale_date?->format('d/m/Y H:i') ?? $sale->created_at->format('d/m/Y H:i') }}</p>
            <p class="text-sm"><strong>Vendedor:</strong> {{ $sale->seller?->name ?? '-' }}</p>
            <p class="text-sm"><strong>Cliente:</strong> {{ $sale->customer_name ?: '-' }}</p>
        </div>

        <div class="bg-white shadow rounded p-4">
            <h2 class="text-sm font-semibold mb-2">Totais</h2>
            <p class="text-sm flex justify-between">
                <span>Subtotal</span>
                <span>R$ {{ number_format($sale->subtotal, 2, ',', '.') }}</span>
            </p>
            <p class="text-sm flex justify-between">
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
            <p class="text-sm flex justify-between font-semibold border-t pt-2 mt-2">
                <span>Total</span>
                <span>R$ {{ number_format($sale->total, 2, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <h2 class="text-sm font-semibold mb-3">Itens da venda</h2>
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50">
                <th class="px-3 py-2 text-left">Material</th>
                <th class="px-3 py-2 text-right">Quantidade</th>
                <th class="px-3 py-2 text-right">Valor unitário (R$)</th>
                <th class="px-3 py-2 text-right">Total (R$)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sale->items as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">
                        <div class="font-semibold">{{ $item->material->name }}</div>
                        <div class="text-xs text-gray-500">{{ $item->material->unit }}</div>
                    </td>
                    <td class="px-3 py-2 text-right">
                        {{ number_format($item->quantity, 3, ',', '.') }} {{ $item->material->unit }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        R$ {{ number_format($item->unit_price, 2, ',', '.') }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        R$ {{ number_format($item->total, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-4">
        <a href="{{ route('sales.index') }}" class="btn-chip btn-chip--primary">
            Voltar para lista de vendas
        </a>
    </div>
@endsection


