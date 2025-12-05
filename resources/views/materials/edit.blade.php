@extends('layouts.app')

@section('title', 'Editar material')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar material</h1>

    <form action="{{ route('materials.update', $material) }}" method="POST" class="bg-white shadow rounded p-4 max-w-2xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Categoria *</label>
                <select name="category_id" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">Selecione...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $material->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Código</label>
                <input type="text" name="code" value="{{ old('code', $material->code) }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Nome *</label>
                <input type="text" name="name" value="{{ old('name', $material->name) }}"
                       class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Unidade *</label>
                <input type="text" name="unit" value="{{ old('unit', $material->unit) }}"
                       class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Estoque mínimo</label>
                <input type="number" step="0.001" min="0" name="minimum_stock"
                       value="{{ old('minimum_stock', $material->minimum_stock) }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Custo médio (R$)</label>
                <input type="number" step="0.01" min="0" name="cost_price"
                       value="{{ old('cost_price', $material->cost_price) }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <p class="mt-4 text-xs text-gray-500">
            O estoque atual ({{ number_format($material->current_stock, 3, ',', '.') }} {{ $material->unit }}) é alterado apenas por movimentações de entrada/saída.
        </p>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('materials.index') }}"
               class="px-4 py-2 text-sm rounded border border-gray-300 text-gray-700">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                Salvar
            </button>
        </div>
    </form>
@endsection


