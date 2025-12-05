@extends('layouts.app')

@section('title', 'Editar categoria')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar categoria</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="bg-white shadow rounded p-4 max-w-xl">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block text-sm font-semibold mb-1">Nome *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                   class="w-full border rounded px-3 py-2 text-sm"
                   required>
        </div>

        <div class="mb-3">
            <label class="block text-sm font-semibold mb-1">Descrição</label>
            <textarea name="description" rows="3"
                      class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('categories.index') }}"
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


