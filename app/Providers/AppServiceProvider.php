<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;                // <--- Importações ficam AQUI no topo
use Illuminate\Support\Facades\Config; // <--- Importações ficam AQUI no topo
use Illuminate\Support\Facades\Schema; // <--- Importações ficam AQUI no topo

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // A lógica do SMTP Dinâmico deve ficar AQUI DENTRO da função boot da classe
        
        // 1. Verifica se a tabela existe para não quebrar migrations iniciais
        if (Schema::hasTable('settings')) {
            
            // 2. Carrega configurações do Banco
            // pluck cria um array tipo: ['mail_host' => 'smtp.mailgun.org', ...]
            $settings = Setting::all()->pluck('value', 'key');

            // 3. Se tiver configuração salva, sobrescreve o .env em tempo de execução
            if (isset($settings['mail_host'])) {
                Config::set('mail.mailers.smtp.host', $settings['mail_host']);
                Config::set('mail.mailers.smtp.port', $settings['mail_port']);
                Config::set('mail.mailers.smtp.username', $settings['mail_username']);
                Config::set('mail.mailers.smtp.password', $settings['mail_password']);
                Config::set('mail.mailers.smtp.encryption', $settings['mail_encryption']);
                Config::set('mail.from.address', $settings['mail_from_address']);
                Config::set('mail.from.name', $settings['mail_from_name']);
            }
        }
    }
}