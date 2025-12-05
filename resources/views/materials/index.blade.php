@extends('layouts.app')

@section('title', 'Materiais')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Materiais</h1>
        <a href="{{ route('materials.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Novo material
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th class="text-center">Código</th>
                    <th>Categoria</th>
                    <th>Nome</th>
                    <th class="text-right">Estoque atual</th>
                    <th class="text-center">Unidade</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materials as $material)
                    <tr>
                        <td class="text-center">
                            {{ $material->code ?: '-' }}
                        </td>
                        <td>{{ $material->category?->name ?? '-' }}</td>
                        <td>
                            <div class="font-weight-bold">{{ $material->name }}</div>
                        </td>
                        <td class="text-right">
                            {{ number_format(
                                $material->current_stock,
                                strtoupper($material->unit) === 'UN' ? 0 : 3,
                                ',',
                                '.'
                            ) }} {{ $material->unit }}
                        </td>
                        <td class="text-center">
                            {{ $material->unit }}
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex align-items-center">
                                <a href="{{ route('materials.edit', $material) }}"
                                   class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                <a href="{{ route('stock-movements.create', ['material_id' => $material->id]) }}"
                                   class="btn btn-primary btn-sm mr-2">
                                    <i class="fas fa-exchange-alt mr-1"></i> Movimentar
                                </a>
                                <form action="{{ route('materials.destroy', $material) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este material?');">
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
                        <td colspan="6" class="text-center text-muted p-3">
                            Nenhum material cadastrado.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($materials->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $materials->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

