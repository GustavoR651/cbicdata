<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    /**
     * Exibe a página de configurações.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $user = auth()->user();
        
        return view('admin.settings', compact('settings', 'user'));
    }

    /**
     * Atualiza configurações gerais e uploads.
     */
    public function update(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return abort(403);
        }

        // Remove campos que não são settings diretos
        $input = $request->except(['_token', '_method', 'site_logo', 'site_favicon']);

        // Salva configurações de texto/select
        foreach ($input as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Upload Logo (Aceita PNG, JPG, WEBP)
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|mimes:png,jpg,jpeg,webp|max:2048']);
            $this->handleUpload($request->file('site_logo'), 'site_logo');
        }

        // Upload Favicon
        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'image|mimes:png,ico,webp|max:1024']);
            $this->handleUpload($request->file('site_favicon'), 'site_favicon');
        }

        // Limpa cache se houver
        Cache::forget('settings');

        return redirect()->back()->with('success', 'Configurações e imagens atualizadas com sucesso!');
    }

    /**
     * Processa o envio de notificação em massa.
     */
    public function sendNotification(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return abort(403);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string', // Conteúdo HTML do TinyMCE
        ]);

        // Pega todos os usuários ativos
        $users = User::where('active', true)->get();

        if ($users->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhum usuário ativo encontrado para enviar.');
        }

        // Envia o e-mail para cada usuário
        foreach ($users as $user) {
            Mail::html($request->message, function ($message) use ($user, $request) {
                $message->to($user->email)
                        ->subject($request->subject);
            });
        }

        return redirect()->back()->with('success', 'Comunicado enviado com sucesso para ' . $users->count() . ' usuários!');
    }

    /**
     * Função auxiliar para upload e substituição de arquivos.
     */
    private function handleUpload($file, $key)
    {
        $old = Setting::where('key', $key)->first();
        
        // Apaga arquivo antigo se existir
        if ($old && $old->value && Storage::disk('public')->exists($old->value)) {
            Storage::disk('public')->delete($old->value);
        }
        
        // Salva novo na pasta 'uploads/settings' no disco 'public'
        $path = $file->store('uploads/settings', 'public');
        
        Setting::updateOrCreate(['key' => $key], ['value' => $path]);
    }
}