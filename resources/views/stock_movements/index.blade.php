@extends('layouts.app')

@section('title', 'Movimentações de estoque')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Movimentações de estoque</h1>
        <a href="{{ route('stock-movements.create') }}"
           class="px-4 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
            Nova movimentação
        </a>
    </div>

    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50">
                <th class="px-3 py-2 text-left">Data</th>
                <th class="px-3 py-2 text-left">Material</th>
                <th class="px-3 py-2 text-left">Tipo</th>
                <th class="px-3 py-2 text-right">Quantidade</th>
                <th class="px-3 py-2 text-right">Estoque antes</th>
                <th class="px-3 py-2 text-right">Estoque depois</th>
                <th class="px-3 py-2 text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($movements as $movement)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2">
                        {{ $movement->movement_date?->format('d/m/Y H:i') ?? $movement->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-3 py-2">
                        <div class="font-semibold">{{ $movement->material->name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $movement->material->category?->name }}
                        </div>
                    </td>
                    <td class="px-3 py-2">
                        @if($movement->type === 'in')
                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Entrada</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Saída</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 text-right">
                        {{ number_format($movement->quantity, 3, ',', '.') }} {{ $movement->material->unit }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        {{ number_format($movement->previous_stock, 3, ',', '.') }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        {{ number_format($movement->resulting_stock, 3, ',', '.') }}
                    </td>
                    <td class="px-3 py-2">
                        <div class="table-actions">
                            <form action="{{ route('stock-movements.destroy', $movement) }}" method="POST"
                                  onsubmit="return confirm('Excluir esta movimentação irá ajustar o estoque para o valor anterior. Confirmar?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn-chip btn-chip--danger">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-3 py-4 text-center text-gray-500">
                        Nenhuma movimentação registrada.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $movements->links() }}
        </div>
    </div>
@endsection


