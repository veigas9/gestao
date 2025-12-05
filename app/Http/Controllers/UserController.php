<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();

        if ($authUser->isSuperAdmin()) {
            $users = User::with('companySetting')->orderBy('name')->paginate(20);
        } else {
            $users = User::with('companySetting')
                ->where('company_setting_id', $authUser->company_setting_id)
                ->orderBy('name')
                ->paginate(20);
        }

        return view('users.index', compact('users', 'authUser'));
    }

    public function create()
    {
        $authUser = auth()->user();

        $companies = $authUser->isSuperAdmin()
            ? CompanySetting::orderBy('company_name')->get()
            : CompanySetting::where('id', $authUser->company_setting_id)->get();

        $roles = $authUser->isSuperAdmin()
            ? [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_USER]
            : [User::ROLE_ADMIN, User::ROLE_USER];

        return view('users.create', compact('companies', 'roles', 'authUser'));
    }

    public function store(Request $request)
    {
        $authUser = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'max:20'],
            'company_setting_id' => ['nullable', 'exists:company_settings,id'],
        ]);

        // Normaliza role e empresa de acordo com o nível do usuário autenticado
        if ($authUser->isSuperAdmin()) {
            $role = $data['role'];
            $companyId = $data['company_setting_id'] ?? null;
        } else {
            // ADMIN só pode criar usuários da própria empresa
            $role = in_array($data['role'], [User::ROLE_ADMIN, User::ROLE_USER], true)
                ? $data['role']
                : User::ROLE_USER;
            $companyId = $authUser->company_setting_id;
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $role,
            'company_setting_id' => $companyId,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(string $id)
    {
        $authUser = auth()->user();

        if ($authUser->isSuperAdmin()) {
            $user = User::with('companySetting')->findOrFail($id);
            $companies = CompanySetting::orderBy('company_name')->get();
            $roles = [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN, User::ROLE_USER];
        } else {
            $user = User::with('companySetting')
                ->where('company_setting_id', $authUser->company_setting_id)
                ->findOrFail($id);

            $companies = CompanySetting::where('id', $authUser->company_setting_id)->get();
            $roles = [User::ROLE_ADMIN, User::ROLE_USER];
        }

        return view('users.edit', compact('user', 'companies', 'roles', 'authUser'));
    }

    public function update(Request $request, string $id)
    {
        $authUser = $request->user();

        if ($authUser->isSuperAdmin()) {
            $user = User::findOrFail($id);
        } else {
            $user = User::where('company_setting_id', $authUser->company_setting_id)
                ->findOrFail($id);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'string', 'max:20'],
            'company_setting_id' => ['nullable', 'exists:company_settings,id'],
        ]);

        if ($authUser->isSuperAdmin()) {
            $role = $data['role'];
            $companyId = $data['company_setting_id'] ?? $user->company_setting_id;
        } else {
            $role = in_array($data['role'], [User::ROLE_ADMIN, User::ROLE_USER], true)
                ? $data['role']
                : User::ROLE_USER;
            $companyId = $authUser->company_setting_id;
        }

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $role,
            'company_setting_id' => $companyId,
        ];

        if (! empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        $user->update($updateData);

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $authUser = auth()->user();

        if ($authUser->isSuperAdmin()) {
            $user = User::findOrFail($id);
        } else {
            $user = User::where('company_setting_id', $authUser->company_setting_id)
                ->findOrFail($id);
        }

        // Evitar que o usuário exclua a si mesmo
        if ($authUser->id === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Você não pode excluir o próprio usuário.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}


