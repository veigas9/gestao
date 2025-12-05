<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = auth()->user()->company_setting_id;

        $categories = Category::where('company_setting_id', $companyId)
            ->orderBy('name')
            ->paginate(15);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $data['company_setting_id'] = $request->user()->company_setting_id;

        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $category = Category::with('materials')
            ->where('company_setting_id', $companyId)
            ->findOrFail($id);

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $category = Category::where('company_setting_id', $companyId)->findOrFail($id);

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $category = Category::where('company_setting_id', $companyId)->findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $category = Category::where('company_setting_id', $companyId)->findOrFail($id);

        // Em um cenário real, você poderia bloquear exclusão se houver materiais vinculados.
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso.');
    }
}
