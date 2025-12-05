@extends('layouts.app')

@section('title', 'Vendas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Vendas</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Nova venda
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Vendedor</th>
                    <th>Cliente</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Desconto</th>
                    <th class="text-right">Total</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>
                            {{ $sale->sale_date?->format('d/m/Y H:i') ?? $sale->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>{{ $sale->seller?->name ?? '-' }}</td>
                        <td>{{ $sale->customer_name ?: '-' }}</td>
                        <td class="text-right">
                            R$ {{ number_format($sale->subtotal, 2, ',', '.') }}
                        </td>
                        <td class="text-right">
                            @if($sale->discount_percent > 0)
                                {{ number_format($sale->discount_percent, 2, ',', '.') }}%
                                (R$ {{ number_format($sale->discount_amount, 2, ',', '.') }})
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right">
                            R$ {{ number_format($sale->total, 2, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-primary btn-sm">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted p-3">
                            Nenhuma venda registrada ainda.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $sales->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
