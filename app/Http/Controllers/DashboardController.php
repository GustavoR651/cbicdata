<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Vote;

class DashboardController extends Controller
{
    public function index()
    {
        // Pega a agenda marcada como PRINCIPAL, ou a última criada se não houver
        $mainAgenda = Agenda::where('is_main_schedule', true)->first() 
                      ?? Agenda::latest()->first();

        // Pega todas as agendas para a lista lateral com a contagem de projetos
        $agendas = Agenda::withCount('projects')
                         ->orderBy('year', 'desc')
                         ->get();

        // Calcula percentual para cada agenda
        foreach($agendas as $agenda) {
            $totalProjects = $agenda->projects_count;
            
            // Correção lógica: Como a tabela 'votes' não tem 'agenda_id',
            // contamos quantos projetos desta agenda possuem votos deste usuário.
            $userVotes = Vote::where('user_id', auth()->id())
                            ->whereHas('project', function($q) use ($agenda) {
                                $q->where('agenda_id', $agenda->id);
                            })
                            ->count();
            
            $agenda->percentual = $totalProjects > 0 ? round(($userVotes / $totalProjects) * 100) : 0;
        }

        return view('dashboard', compact('mainAgenda', 'agendas'));
    }
}