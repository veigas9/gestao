@extends('layouts.app')

@section('title', 'Movimentações de estoque')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Movimentações de estoque</h1>
        <a href="{{ route('stock-movements.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Nova movimentação
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Material</th>
                    <th>Tipo</th>
                    <th class="text-right">Quantidade</th>
                    <th class="text-right">Estoque antes</th>
                    <th class="text-right">Estoque depois</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td>
                            {{ $movement->movement_date?->format('d/m/Y H:i') ?? $movement->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div class="font-weight-bold">{{ $movement->material->name }}</div>
                            <div class="text-muted small">
                                {{ $movement->material->category?->name }}
                            </div>
                        </td>
                        <td>
                            @if($movement->type === 'in')
                                <span class="badge badge-success">Entrada</span>
                            @else
                                <span class="badge badge-danger">Saída</span>
                            @endif
                        </td>
                        <td class="text-right">
                            {{ number_format($movement->quantity, 3, ',', '.') }} {{ $movement->material->unit }}
                        </td>
                        <td class="text-right">
                            {{ number_format($movement->previous_stock, 3, ',', '.') }}
                        </td>
                        <td class="text-right">
                            {{ number_format($movement->resulting_stock, 3, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <form action="{{ route('stock-movements.destroy', $movement) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Excluir esta movimentação irá ajustar o estoque para o valor anterior. Confirmar?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted p-3">
                            Nenhuma movimentação registrada.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($movements->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $movements->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection

