@extends('layouts.app')

@section('title', 'Novo material')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Novo material</h1>

    <form action="{{ route('materials.store') }}" method="POST" class="max-w-2xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Categoria *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Código</label>
                <input type="text" name="code" value="{{ old('code') }}"
                       class="form-input">
            </div>

            <div>
                <label class="form-label">Nome *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-input" required>
            </div>

            <div>
                <label class="form-label">Unidade *</label>
                <input type="text" name="unit" value="{{ old('unit', 'UN') }}"
                       class="form-input" required>
            </div>

            <div>
                <label class="form-label">Estoque mínimo</label>
                <input type="number" step="0.001" min="0" name="minimum_stock"
                       value="{{ old('minimum_stock') }}"
                       class="form-input">
            </div>

            <div>
                <label class="form-label">Custo médio (R$)</label>
                <input type="number" step="0.01" min="0" name="cost_price"
                       value="{{ old('cost_price') }}"
                       class="form-input">
            </div>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('materials.index') }}" class="btn-link">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Salvar
            </button>
        </div>
    </form>
@endsection


