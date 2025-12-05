@extends('layouts.app')

@section('title', 'Nova venda')

@section('content_header')
    <h1>Nova venda</h1>
@endsection

@section('content')
    <form action="{{ route('sales.store') }}" method="POST" id="sale-form"
          data-materials='@json($materialsForJs)'>
        @csrf

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dados da venda</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="customer_name">Cliente</label>
                        <input type="text" name="customer_name" id="customer_name"
                               value="{{ old('customer_name') }}"
                               class="form-control"
                               placeholder="Nome do cliente (opcional)">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="discount_percent">Desconto (%)</label>
                        <input type="number" step="0.01" min="0" max="100"
                               name="discount_percent" id="discount_percent"
                               value="{{ old('discount_percent', 0) }}"
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Itens da venda</h3>
                <button type="button" id="add-sale-item" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Adicionar produto
                </button>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap mb-0" id="sale-items-table">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th class="text-right">Estoque</th>
                        <th class="text-right">Quantidade</th>
                        <th class="text-right">Valor unitário (R$)</th>
                        <th class="text-right">Total item (R$)</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="sale-items-body">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-3 col-md-4 offset-md-8 p-0">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <span>Subtotal</span>
                    <span id="sale-subtotal-display">R$ 0,00</span>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span>Desconto</span>
                    <span id="sale-discount-display">R$ 0,00</span>
                </div>
                <div class="d-flex justify-content-between font-weight-bold border-top pt-2 mt-2">
                    <span>Total da venda</span>
                    <span id="sale-total-display">R$ 0,00</span>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('sales.index') }}" class="btn btn-default mr-2">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                Finalizar venda
            </button>
        </div>
    </form>
@endsection



