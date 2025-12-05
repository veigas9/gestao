@extends('layouts.app')

@section('title', 'Categorias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Categorias</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Nova categoria
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="font-weight-bold">{{ $category->name }}</td>
                    <td>
                        {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted p-3">
                        Nenhuma categoria cadastrada.
                    </td>
                </tr>
            @endforelse
            </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $categories->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

