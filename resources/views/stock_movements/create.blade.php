@extends('layouts.app')

@section('title', 'Nova movimentação de estoque')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nova movimentação de estoque</h1>

    <form action="{{ route('stock-movements.store') }}" method="POST" class="max-w-2xl"
          id="stock-movement-form"
          data-materials='@json($materialsForJs)'>
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Material *</label>
                <select name="material_id" id="material_id"
                        class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="">Selecione...</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}"
                            @selected(request('material_id') == $material->id || old('material_id') == $material->id)>
                            {{ $material->name }} ({{ $material->unit }})
                        </option>
                    @endforeach
                </select>
                <div id="current-stock-info" class="mt-1 text-xs text-gray-600"></div>
            </div>

            <div>
                <label class="form-label">Tipo *</label>
                <select name="type" id="movement_type"
                        class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="in" @selected(old('type') === 'in')>Entrada</option>
                    <option value="out" @selected(old('type') === 'out')>Saída</option>
                </select>
            </div>

            <div>
                <label class="form-label">Quantidade *</label>
                <input type="number" step="0.001" min="0.001" name="quantity" id="quantity"
                       value="{{ old('quantity') }}"
                       class="w-full border rounded px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="form-label">Valor unitário (R$)</label>
                <input type="number" step="0.01" min="0" name="unit_price"
                       value="{{ old('unit_price') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="form-label">Data da movimentação</label>
                <input type="datetime-local" name="movement_date"
                       value="{{ old('movement_date') }}"
                       class="w-full border rounded px-3 py-2 text-sm">
            </div>
        </div>

        <div class="mt-4 text-sm text-gray-700" id="resulting-stock-info"></div>

        <div class="mt-4">
            <label class="form-label">Observações</label>
            <textarea name="notes" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('stock-movements.index') }}" class="btn-link">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Registrar movimentação
            </button>
        </div>
    </form>
@endsection


