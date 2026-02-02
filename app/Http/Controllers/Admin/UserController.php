<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Listar Usuários
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Formulário Novo
    public function create() {
        return view('admin.users.create');
    }

    // Salvar Usuário
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // Adicione validações extras aqui (cargo, empresa)
        ]);

        // Senha aleatória se não enviada
        $password = $request->password ?? Str::random(10);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? 'user',
            'password' => Hash::make($password),
            'associacao' => $request->associacao,
            'cargo' => $request->cargo,
            'telefone' => $request->telefone,
        ]);

        // Aqui você pode enviar o e-mail de boas-vindas com a senha $password

        return redirect()->route('admin.users.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    // Editar Usuário
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Atualizar Usuário
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $data = $request->only(['name', 'email', 'role', 'associacao', 'cargo', 'telefone']);
        
        if($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Dados atualizados.');
    }

    // Excluir
    public function destroy($id) {
        if(auth()->id() == $id) {
            return back()->with('error', 'Você não pode excluir a si mesmo.');
        }
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário removido.');
    }

    // Resetar Senha (Ação Rápida)
    public function resetPassword($id) {
        $user = User::findOrFail($id);
        $newPass = Str::random(10);
        $user->update(['password' => Hash::make($newPass)]);
        
        // Enviar E-mail...
        
        return back()->with('password_reset', "Senha alterada para: <strong>{$newPass}</strong>");
    }
}