<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = auth()->user()->company_setting_id;

        $materials = Material::with('category')
            ->where('company_setting_id', $companyId)
            ->orderBy('name')
            ->paginate(15);

        $categories = Category::where('company_setting_id', $companyId)
            ->orderBy('name')
            ->get();

        return view('materials.index', compact('materials', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyId = auth()->user()->company_setting_id;

        $categories = Category::where('company_setting_id', $companyId)
            ->orderBy('name')
            ->get();

        return view('materials.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100', 'unique:materials,code'],
            'unit' => ['required', 'string', 'max:20'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['current_stock'] = 0;
        $data['company_setting_id'] = $request->user()->company_setting_id;

        Material::create($data);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $material = Material::with(['category', 'stockMovements' => function ($q) {
            $q->orderByDesc('movement_date');
        }])->where('company_setting_id', $companyId)->findOrFail($id);

        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $material = Material::where('company_setting_id', $companyId)->findOrFail($id);
        $categories = Category::where('company_setting_id', $companyId)
            ->orderBy('name')
            ->get();

        return view('materials.edit', compact('material', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $material = Material::where('company_setting_id', $companyId)->findOrFail($id);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100', 'unique:materials,code,' . $material->id],
            'unit' => ['required', 'string', 'max:20'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $material->update($data);

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyId = auth()->user()->company_setting_id;

        $material = Material::where('company_setting_id', $companyId)->findOrFail($id);

        // Em produção, considere bloquear se houver movimentos de estoque vinculados.
        $material->delete();

        return redirect()
            ->route('materials.index')
            ->with('success', 'Material excluído com sucesso.');
    }
}
