<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Verifica se o email já existe para evitar erro
        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        // Gera senha aleatória segura
        $password = Str::random(10);

        return new User([
            'name'       => $row['name'] ?? $row['nome'], // Aceita 'name' ou 'nome'
            'email'      => $row['email'],
            'password'   => Hash::make($password),
            'role'       => $row['role'] ?? 'user', // Default 'user'
            'associacao' => $row['associacao'] ?? null,
            'cargo'      => $row['cargo'] ?? null,
            'telefone'   => $row['telefone'] ?? null,
            'active'     => true,
        ]);
        
        // Opcional: Enviar email com a senha $password para o usuário aqui
    }
}