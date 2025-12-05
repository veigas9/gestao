@extends('layouts.app')

@section('title', 'Editar loja')

@section('content_header')
    <h1>Editar loja</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dados da loja</h3>
        </div>
        <form action="{{ route('stores.update', $store) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                @include('stores.partials._form-fields', ['store' => $store])
            </div>
            <div class="card-footer d-flex justify-content-end">
                <a href="{{ route('stores.index') }}" class="btn btn-default mr-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </div>
        </form>
    </div>
@endsection


