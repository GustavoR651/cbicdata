<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Project; 
use App\Models\Vote;

class DashboardController extends Controller
{
    public function index() {
        $stats = [
            'agendas'  => Agenda::count(),
            'projetos' => Project::count(),
            'votos'    => Vote::count(),
            'usuarios' => User::where('role', 'user')->count(),
        ];

        // Busca Agendas para o Widget do Dashboard
        $agendas = Agenda::withCount('projects')
            ->orderByRaw("deadline >= NOW() DESC") 
            ->orderBy('deadline', 'desc')          
            ->limit(5)                             
            ->get();

        return view('admin.dashboard', compact('agendas', 'stats'));
    }
}