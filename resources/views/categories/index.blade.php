@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Categorias</h1>
        <a href="{{ route('categories.create') }}"
           class="px-4 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
            Nova categoria
        </a>
    </div>

    <div class="bg-white shadow rounded p-4">
        <table class="min-w-full text-sm">
            <thead>
            <tr class="border-b bg-gray-50">
                <th class="px-3 py-2 text-left">Nome</th>
                <th class="px-3 py-2 text-left">Descrição</th>
                <th class="px-3 py-2 text-right">Ações</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-2 font-semibold">{{ $category->name }}</td>
                    <td class="px-3 py-2 text-gray-700">
                        {{ \Illuminate\Support\Str::limit($category->description, 80) }}
                    </td>
                    <td class="px-3 py-2 text-right">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="text-xs px-2 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">
                            Editar
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs px-2 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-3 py-4 text-center text-gray-500">
                        Nenhuma categoria cadastrada.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
@endsection


