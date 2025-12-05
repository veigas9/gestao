<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = CompanySetting::orderBy('company_name')->paginate(20);

        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        $store = new CompanySetting([
            'state' => 'RS',
            'tax_regime' => 'MEI',
            'nfe_environment' => 'homologacao',
            'nfe_series' => '1',
        ]);

        return view('stores.create', compact('store'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        CompanySetting::create($data);

        return redirect()
            ->route('stores.index')
            ->with('success', 'Loja cadastrada com sucesso.');
    }

    public function edit(string $id)
    {
        $store = CompanySetting::findOrFail($id);

        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, string $id)
    {
        $store = CompanySetting::findOrFail($id);

        $data = $this->validateData($request, $store->id);

        $store->update($data);

        return redirect()
            ->route('stores.index')
            ->with('success', 'Loja atualizada com sucesso.');
    }

    public function destroy(string $id)
    {
        $store = CompanySetting::findOrFail($id);

        // Em produção, ideal checar se há usuários vinculados antes de excluir
        $store->delete();

        return redirect()
            ->route('stores.index')
            ->with('success', 'Loja excluída com sucesso.');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'trade_name' => ['nullable', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:14'],
            'ie' => ['nullable', 'string', 'max:20'],
            'im' => ['nullable', 'string', 'max:20'],
            'tax_regime' => ['required', 'string', 'max:20'],
            'cnae' => ['nullable', 'string', 'max:20'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'city_ibge_code' => ['nullable', 'string', 'max:7'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['nullable', 'string', 'max:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'nfe_environment' => ['required', 'in:homologacao,producao'],
            'nfe_series' => ['required', 'string', 'max:3'],
            'nfe_cert_path' => ['nullable', 'string', 'max:255'],
        ]);
    }
}


