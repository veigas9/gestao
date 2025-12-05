@extends('layouts.app')

@section('title', 'Nova categoria')

@section('content_header')
    <h1>Nova categoria</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados da categoria</h3>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Nome *</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           required>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="form-control"
                              placeholder="Ex.: Materiais elétricos, Hidráulica, Acabamentos...">{{ old('description') }}</textarea>
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


