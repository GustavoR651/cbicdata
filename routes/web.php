<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controladores do USUÁRIO (Frontend)
use App\Http\Controllers\User\UserDashboardController; 
use App\Http\Controllers\User\VotingController; 

// Controladores do ADMIN (Backend)
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redireciona a raiz para o login
Route::get('/', function () {
    return redirect()->route('login');
});

// ==============================================================================
// 1. ÁREA DO USUÁRIO (RESPONSÁVEL TÉCNICO)
// ==============================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Painel Geral
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // --- Fluxo de Votação ---
    Route::get('/agenda/{id}/votar', [VotingController::class, 'show'])->name('agenda.vote');
    Route::post('/vote/store', [VotingController::class, 'store'])->name('vote.store');
    Route::delete('/vote/destroy', [VotingController::class, 'destroy'])->name('vote.destroy');
    
    // Rota para exportar os votos do próprio usuário (Corrigido para UserDashboardController)
    Route::get('/agenda/{id}/exportar-votos/{type}', [UserDashboardController::class, 'exportMyVotes'])
        ->name('agenda.export_my_votes');

    // Rotas de Perfil (Padrão Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================================================================
// 2. ÁREA DO ADMINISTRADOR (GESTÃO TOTAL)
// ==============================================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.') // Prefixo para nomes: admin.dashboard, admin.agendas...
    ->group(function () {

    // --- DASHBOARD GERAL ---
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // --- MÓDULO: AGENDAS LEGISLATIVAS ---
    Route::prefix('agendas')->name('agendas.')->group(function() {
        
        // Listagem e CRUD Básico
        Route::get('/', [AdminAgendaController::class, 'index'])->name('index');
        Route::get('/nova', [AdminAgendaController::class, 'create'])->name('create'); 
        Route::post('/nova', [AdminAgendaController::class, 'store'])->name('store');
        
        // Visualizar e Dashboard
        Route::get('/{id}/painel', [AdminAgendaController::class, 'dashboard'])->name('dashboard'); // Painel Estatístico
        Route::get('/{id}', [AdminAgendaController::class, 'show'])->name('show'); // Lista de Projetos (Principal)
        
        Route::get('/{id}/editar', [AdminAgendaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminAgendaController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminAgendaController::class, 'destroy'])->name('destroy');

        // Funcionalidades Específicas
        Route::post('/check-file', [AdminAgendaController::class, 'checkFile'])->name('check_file');
        Route::get('/{id}/download/{type}', [AdminAgendaController::class, 'download'])->name('download');
        
        // Relatórios
        Route::get('/{id}/relatorio', [AdminAgendaController::class, 'report'])->name('report');
        Route::get('/{id}/exportar/{type}', [AdminAgendaController::class, 'exportExcel'])->name('export'); // Excel Admin

        // Resetar Votos
        Route::delete('/{agenda}/user/{user}/reset', [AdminAgendaController::class, 'resetUserVotes'])->name('reset.user');
    });

    // --- MÓDULO: GESTÃO DE USUÁRIOS ---
    Route::prefix('usuarios')->name('users.')->group(function() {
        
        // Rota de Relatório (Deve vir ANTES de /{user} para não dar conflito)
        Route::get('/report', [AdminUserController::class, 'report'])->name('report');

        // Listagem e CRUD
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/novo', [AdminUserController::class, 'create'])->name('create');
        Route::post('/novo', [AdminUserController::class, 'store'])->name('store');
        
        Route::get('/{user}/editar', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        
        // Ações Específicas
        Route::post('/{user}/reset-senha', [AdminUserController::class, 'resetPassword'])->name('reset_password');

        // NOVAS ROTAS DE IMPORTAÇÃO
        Route::post('/import', [AdminUserController::class, 'import'])->name('import');
        Route::get('/template', [AdminUserController::class, 'downloadTemplate'])->name('template');
    });

    // --- MÓDULO: CONFIGURAÇÕES ---
    Route::get('/configuracoes', [AdminSettingController::class, 'index'])->name('settings');
    Route::put('/configuracoes', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::put('/configuracoes', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('/configuracoes/enviar-notificacao', [AdminSettingController::class, 'sendNotification'])->name('settings.send_notification');
    
    });

require __DIR__.'/auth.php';