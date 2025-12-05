@extends('layouts.app')

@section('title', 'Materiais')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Materiais</h1>
        <a href="{{ route('materials.create') }}"
           class="px-4 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
            Novo material
        </a>
    </div>

    <div class="bg-white shadow rounded p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="border-b bg-gray-50">
                    <th class="px-3 py-2 text-left">Categoria</th>
                    <th class="px-3 py-2 text-left">Nome</th>
                    <th class="px-3 py-2 text-right">Estoque atual</th>
                    <th class="px-3 py-2 text-right">Estoque mínimo</th>
                    <th class="px-3 py-2 text-right">Custo médio</th>
                    <th class="px-3 py-2 text-center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @forelse($materials as $material)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">
                            {{ $material->category?->name ?? '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <div class="font-semibold">{{ $material->name }}</div>
                            @if($material->code)
                                <div class="text-xs text-gray-500">Código: {{ $material->code }}</div>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right">
                            {{ number_format($material->current_stock, 3, ',', '.') }} {{ $material->unit }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            {{ $material->minimum_stock ? number_format($material->minimum_stock, 3, ',', '.') : '-' }}
                        </td>
                        <td class="px-3 py-2 text-right">
                            {{ $material->cost_price ? 'R$ '.number_format($material->cost_price, 2, ',', '.') : '-' }}
                        </td>
                        <td class="px-3 py-2">
                            <div class="table-actions">
                                <a href="{{ route('materials.edit', $material) }}"
                                   class="btn-chip btn-chip--warning">
                                    Editar
                                </a>
                                <a href="{{ route('stock-movements.create', ['material_id' => $material->id]) }}"
                                   class="btn-chip btn-chip--primary">
                                    Movimentar
                                </a>
                                <form action="{{ route('materials.destroy', $material) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este material?');">
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
                        <td colspan="6" class="px-3 py-4 text-center text-gray-500">
                            Nenhum material cadastrado.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $materials->links() }}
        </div>
    </div>
@endsection


