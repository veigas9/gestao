@extends('layouts.app')

@section('title', 'Nova venda')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nova venda</h1>

    <form action="{{ route('sales.store') }}" method="POST" class="max-w-4xl" id="sale-form"
          data-materials='@json($materialsForJs)'>
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="form-label">Cliente</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-input"
                       placeholder="Nome do cliente (opcional)">
            </div>

            <div>
                <label class="form-label">Desconto (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="discount_percent" id="discount_percent"
                       value="{{ old('discount_percent', 0) }}"
                       class="form-input">
            </div>
        </div>

        <div class="bg-white shadow rounded p-4 mb-4">
            <h2 class="text-sm font-semibold mb-3">Itens da venda</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm" id="sale-items-table">
                    <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="px-3 py-2 text-left">Material</th>
                        <th class="px-3 py-2 text-right">Estoque</th>
                        <th class="px-3 py-2 text-right">Quantidade</th>
                        <th class="px-3 py-2 text-right">Valor unitário (R$)</th>
                        <th class="px-3 py-2 text-right">Total item (R$)</th>
                        <th class="px-3 py-2 text-center">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="sale-items-body">
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-sale-item"
                    class="btn-chip btn-chip--primary mt-3">
                Adicionar produto
            </button>
        </div>

        <div class="bg-white shadow rounded p-4 max-w-md ml-auto">
            <div class="flex justify-between text-sm mb-1">
                <span>Subtotal</span>
                <span id="sale-subtotal-display">R$ 0,00</span>
            </div>
            <div class="flex justify-between text-sm mb-1">
                <span>Desconto</span>
                <span id="sale-discount-display">R$ 0,00</span>
            </div>
            <div class="flex justify-between text-sm font-semibold mt-2 border-t pt-2">
                <span>Total da venda</span>
                <span id="sale-total-display">R$ 0,00</span>
            </div>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('sales.index') }}" class="btn-link">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Finalizar venda
            </button>
        </div>
    </form>
@endsection


