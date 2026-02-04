<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel; // Necessário para importação
use App\Imports\UsersImport; // Necessário para importação

class UserController extends Controller
{
    /**
     * Listar Usuários com Dashboard e Filtros
     */
    public function index(Request $request)
    {
        // 1. Métricas do Dashboard
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        $onlineUsers = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', now()->subMinutes(5)->getTimestamp())
            ->distinct('user_id')
            ->count();

        // 2. Listagem com Filtros
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('associacao', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'totalUsers', 'totalAdmins', 'onlineUsers'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'associacao' => 'nullable|string',
            'cargo' => 'nullable|string',
            'telefone' => 'nullable|string'
        ]);
        
        $data['password'] = Hash::make($request->password);
        
        User::create($data);
        
        return redirect()->route('admin.users.index')->with('success', 'Usuário criado com sucesso.');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required',
            'associacao' => 'nullable|string',
            'cargo' => 'nullable|string',
            'telefone' => 'nullable|string'
        ]);

        if($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy($id) {
        if(auth()->id() == $id) {
            return back()->with('error', 'Você não pode excluir a si mesmo.');
        }
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário removido.');
    }

    public function resetPassword($id) {
        $user = User::findOrFail($id);
        $newPass = Str::random(10);
        
        $user->update(['password' => Hash::make($newPass)]);
        
        return back()->with('success', "Senha resetada para: {$newPass} (Copie agora!)");
    }

    public function report() {
        $users = User::with(['votes' => function($q) {
            $q->latest()->limit(1); 
        }])->orderBy('name')->get();

        return view('admin.users.report', compact('users'));
    }

    // --- NOVOS MÉTODOS PARA IMPORTAÇÃO ---

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));
            return redirect()->back()->with('success', 'Importação em lote concluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro na importação: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = ['Content-Type' => 'text/csv'];
        $columns = ['nome', 'email', 'role', 'associacao', 'cargo', 'telefone']; // Cabeçalhos do Excel
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Escreve o cabeçalho
            // Linha de exemplo
            fputcsv($file, ['João Exemplo', 'joao@email.com', 'user', 'Sinduscon-SP', 'Diretor', '11999999999']);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="modelo_importacao_usuarios.csv"',
        ]);
    }
}