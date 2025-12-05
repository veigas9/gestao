@extends('layouts.app')

@section('title', 'Novo material')

@section('content_header')
    <h1>Novo material</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados do material</h3>
        </div>
        <form action="{{ route('materials.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="category_id">Categoria *</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="code">Código</label>
                        <input type="text" name="code" id="code"
                               value="{{ old('code') }}"
                               class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nome *</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               class="form-control" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="unit">Unidade *</label>
                        <input type="text" name="unit" id="unit"
                               value="{{ old('unit', 'UN') }}"
                               class="form-control" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="sale_price">Preço padrão de venda (R$)</label>
                        <input type="number" step="0.01" min="0" name="sale_price" id="sale_price"
                               value="{{ old('sale_price') }}"
                               class="form-control" placeholder="Ex: 120,00">
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('materials.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection


