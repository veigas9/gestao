@extends('layouts.app')

@section('title', 'Editar categoria')

@section('content_header')
    <h1>Editar categoria</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados da categoria</h3>
        </div>
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $category->name) }}"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description" rows="3"
                              class="form-control">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('categories.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection


