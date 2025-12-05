@extends('layouts.app')

@section('title', 'Nova movimentação de estoque')

@section('content_header')
    <h1>Nova movimentação de estoque</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados da movimentação</h3>
        </div>
        <form action="{{ route('stock-movements.store') }}" method="POST"
              id="stock-movement-form"
              data-materials='@json($materialsForJs)'>
            @csrf

            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="material_id">Material *</label>
                        <select name="material_id" id="material_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}"
                                    @selected(request('material_id') == $material->id || old('material_id') == $material->id)>
                                    {{ $material->name }} ({{ $material->unit }})
                                </option>
                            @endforeach
                        </select>
                        <small id="current-stock-info" class="form-text text-muted mt-1"></small>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="movement_type">Tipo *</label>
                        <select name="type" id="movement_type" class="form-control" required>
                            <option value="in" @selected(old('type') === 'in')>Entrada</option>
                            <option value="out" @selected(old('type') === 'out')>Saída</option>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="quantity">Quantidade *</label>
                        <input type="number" step="0.001" min="0.001" name="quantity" id="quantity"
                               value="{{ old('quantity') }}"
                               class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="unit_price">Valor unitário (R$)</label>
                        <input type="number" step="0.01" min="0" name="unit_price" id="unit_price"
                               value="{{ old('unit_price') }}"
                               class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="movement_date">Data da movimentação</label>
                        <input type="datetime-local" name="movement_date" id="movement_date"
                               value="{{ old('movement_date') }}"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label>Estoque após a movimentação</label>
                    <p class="form-control-plaintext text-muted mb-2" id="resulting-stock-info"></p>
                </div>

                <div class="form-group">
                    <label for="notes">Observações</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-control">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('stock-movements.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Registrar movimentação
                </button>
            </div>
        </form>
    </div>
@endsection


