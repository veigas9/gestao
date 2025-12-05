@extends('layouts.app')

@section('title', 'Nova categoria')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Nova categoria</h1>

    <form action="{{ route('categories.store') }}" method="POST" class="max-w-xl">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome *</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="form-input"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" rows="3"
                      class="form-textarea">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('categories.index') }}" class="btn-link">
                Cancelar
            </a>
            <button type="submit" class="btn-primary">
                Salvar
            </button>
        </div>
    </form>
@endsection


