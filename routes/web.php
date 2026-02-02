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
    
    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rota para exportar os votos do próprio usuário
    Route::get('/agenda/{id}/exportar-votos/{type}', [UserAgendaController::class, 'exportMyVotes'])
        ->name('agenda.export_my_votes');
        
    });

// ==============================================================================
// 2. ÁREA DO ADMINISTRADOR (GESTÃO TOTAL)
// ==============================================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.') // Todas as rotas aqui começam com admin.
    ->group(function () {

    // --- DASHBOARD GERAL ---
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // --- MÓDULO: AGENDAS LEGISLATIVAS ---
    Route::prefix('agendas')->name('agendas.')->group(function() {
        
        // Listagem
        Route::get('/', [AdminAgendaController::class, 'index'])->name('index');
        
        // Criar
        Route::get('/nova', [AdminAgendaController::class, 'create'])->name('create'); 
        Route::post('/nova', [AdminAgendaController::class, 'store'])->name('store');
        
        // AJAX Check File
        Route::post('/check-file', [AdminAgendaController::class, 'checkFile'])->name('check_file');
        
        // Download
        Route::get('/{id}/download/{type}', [AdminAgendaController::class, 'download'])->name('download');

        // Rota para o Relatório de Impressão/PDF
        Route::get('agendas/{id}/relatorio', [AdminAgendaController::class, 'report'])->name('report');
        
        // Rota para Exportação Excel (Relatórios)
        Route::get('/{id}/exportar/{type}', [AdminAgendaController::class, 'exportExcel'])->name('export');

        // Visualizar
        Route::get('/{agenda}', [AdminAgendaController::class, 'show'])->name('show');
        
        // Editar
        Route::get('/{id}/editar', [AdminAgendaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminAgendaController::class, 'update'])->name('update');
        
        // Excluir
        Route::delete('/{id}', [AdminAgendaController::class, 'destroy'])->name('destroy');
        
        // Resetar Votos
        Route::delete('/{agenda}/user/{user}/reset', [AdminAgendaController::class, 'resetUserVotes'])->name('reset.user');
        
        // Projetos
Route::get('/{id}/projetos', [AdminAgendaController::class, 'projects'])->name('projects');
    });

    // --- MÓDULO: GESTÃO DE USUÁRIOS ---
    Route::prefix('usuarios')->name('users.')->group(function() {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        
        Route::get('/novo', [AdminUserController::class, 'create'])->name('create');
        Route::post('/novo', [AdminUserController::class, 'store'])->name('store');
        
        Route::get('/{user}/editar', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        Route::post('/{user}/reset-senha', [AdminUserController::class, 'resetPassword'])->name('reset_password');
    });

    // --- MÓDULO: CONFIGURAÇÕES ---
    Route::get('/configuracoes', [AdminSettingController::class, 'index'])->name('settings');
    Route::put('/configuracoes', [AdminSettingController::class, 'update'])->name('settings.update');

});

require __DIR__.'/auth.php';