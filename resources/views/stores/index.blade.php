@extends('layouts.app')

@section('title', 'Lojas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Lojas</h1>
        <a href="{{ route('stores.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Nova loja
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Nome fantasia</th>
                    <th>Razão social</th>
                    <th>CNPJ</th>
                    <th>Cidade / UF</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($stores as $store)
                    <tr>
                        <td>{{ $store->trade_name ?: '-' }}</td>
                        <td>{{ $store->company_name }}</td>
                        <td>{{ $store->cnpj }}</td>
                        <td>{{ $store->city }} / {{ $store->state }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex align-items-center">
                                <a href="{{ route('stores.edit', $store) }}"
                                   class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                <form action="{{ route('stores.destroy', $store) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta loja?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-3">
                            Nenhuma loja cadastrada.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($stores->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $stores->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection


