<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. TABELA USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user'); 
            $table->boolean('active')->default(true);
            
            // Campos de Perfil e Monitorização (CBIC)
            $table->string('cargo')->nullable();
            $table->string('associacao')->nullable();
            $table->string('telefone')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('requires_renewal')->default(false);
            
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. TABELA AGENDAS
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('year');
            $table->dateTime('deadline');
            
            // Campos de Cronograma e Ficheiros
            $table->dateTime('start_date')->nullable()->comment('Inicio do Ciclo');
            $table->dateTime('results_date')->nullable()->comment('Divulgação Resultados');
            $table->boolean('is_main_schedule')->default(false);
            $table->boolean('allow_editing')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('file_path')->nullable(); // Caminho da Planilha
            $table->timestamps();
        });

        // 3. TABELA PROJECTS (Estrutura Completa para Filtros Excel)
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('cascade');
            $table->string('codigo')->index();
            $table->string('type')->default('agenda')->index(); // agenda ou remanescente
            $table->string('autor')->nullable();
            $table->string('partido')->nullable();
            $table->string('uf', 2)->nullable();
            $table->text('ementa')->nullable();
            $table->string('tema')->nullable()->index();
            $table->string('subtema')->nullable();
            $table->string('foco')->nullable();
            $table->string('celula_tematica')->nullable();
            $table->string('orgao_origem')->nullable();
            $table->string('posicao_recente')->nullable();
            $table->string('referencia_posicao')->nullable();
            $table->string('localizacao_atual')->nullable();
            $table->string('situacao')->nullable();
            $table->string('tipo_resultado')->nullable();
            $table->string('tipo_forma')->nullable();
            $table->string('regime_tramitacao')->nullable();
            $table->string('orgao_localizacao')->nullable();
            $table->date('data_posicao')->nullable();
            $table->date('data_localizacao')->nullable();
            $table->string('link_pdf', 500)->nullable();
            $table->string('prioridade_original')->nullable();
            $table->integer('ano_agenda')->default(2026);
            $table->timestamps();
        });

        // 4. TABELA DE VOTOS
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('prioridade'); 
            $table->string('posicao');    
            $table->text('ressalva')->nullable();
            $table->unique(['user_id', 'project_id']);
            $table->timestamps();
        });

        // 5. TABELA DE PERMISSÕES ADICIONAIS
        Schema::create('agenda_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('can_edit_after_submit')->default(false);
        });

        // 6. TABELA SETTINGS
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // 7. TABELAS DE SISTEMA (Laravel Default)
        Schema::create('cache', function ($table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        Schema::create('sessions', function ($table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('agenda_user');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('agendas');
        Schema::dropIfExists('users');
    }
};