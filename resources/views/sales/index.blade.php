@extends('layouts.app')

@section('title', 'Vendas')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Vendas</h1>
        <a href="{{ route('sales.create') }}"
           class="px-4 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
            Nova venda
        </a>
    </div>

    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50">
                <th class="px-3 py-2 text-left">Data</th>
                <th class="px-3 py-2 text-left">Vendedor</th>
                <th class="px-3 py-2 text-left">Cliente</th>
                <th class="px-3 py-2 text-right">Subtotal</th>
                <th class="px-3 py-2 text-right">Desconto</th>
                <th class="px-3 py-2 text-right">Total</th>
                <th class="px-3 py-2 text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($sales as $sale)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">
                        {{ $sale->sale_date?->format('d/m/Y H:i') ?? $sale->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-3 py-2">
                        {{ $sale->seller?->name ?? '-' }}
                    </td>
                    <td class="px-3 py-2">
                        {{ $sale->customer_name ?: '-' }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        R$ {{ number_format($sale->subtotal, 2, ',', '.') }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        @if($sale->discount_percent > 0)
                            {{ number_format($sale->discount_percent, 2, ',', '.') }}%
                            (R$ {{ number_format($sale->discount_amount, 2, ',', '.') }})
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-3 py-2 text-right">
                        R$ {{ number_format($sale->total, 2, ',', '.') }}
                    </td>
                    <td class="px-3 py-2">
                        <div class="table-actions">
                            <a href="{{ route('sales.show', $sale) }}"
                               class="btn-chip btn-chip--primary">
                                Detalhes
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                        Nenhuma venda registrada ainda.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $sales->links() }}
        </div>
    </div>
@endsection


