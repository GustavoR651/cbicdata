<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Certifique-se de ter esse Model

class SettingController extends Controller
{
    public function index() {
        // Pega a primeira configuração ou cria uma vazia para não dar erro
        $settings = Setting::first() ?? new Setting();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request) {
        $setting = Setting::first();
        if(!$setting) {
            $setting = new Setting();
        }

        // Valide e salve seus campos aqui
        // Exemplo:
        // $setting->site_name = $request->site_name;
        // $setting->save();

        return back()->with('success', 'Configurações salvas.');
    }
}