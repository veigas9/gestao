<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $setting = $user?->companySetting;

        if (! $setting) {
            $setting = new CompanySetting([
                'state' => 'RS',
                'tax_regime' => 'MEI',
                'nfe_environment' => 'homologacao',
                'nfe_series' => '1',
            ]);
        }

        return view('company_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
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

        $user = $request->user();
        $setting = $user->companySetting;

        if ($setting) {
            $setting->update($data);
        } else {
            $setting = CompanySetting::create($data);
            $user->company_setting_id = $setting->id;
            $user->save();
        }

        return redirect()
            ->route('company-settings.edit')
            ->with('success', 'Dados da empresa salvos com sucesso.');
    }
}


