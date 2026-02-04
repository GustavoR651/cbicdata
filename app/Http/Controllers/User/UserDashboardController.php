<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserVotesExport; // Importe sua classe de exportação
use App\Models\Agenda;
use App\Models\Setting;

class UserDashboardController extends Controller
{
    /**
     * 1. DASHBOARD DO USUÁRIO
     * Mostra o cronograma dinâmico e a lista de agendas com progresso.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Busca texto informativo configurado no banco (Fallback se não existir)
        $infoText = Setting::where('key', 'voting_info_text')->value('value') 
                    ?? "Bem-vindo ao sistema de votação da Agenda Legislativa da CBIC.";

        // Pega a agenda PRINCIPAL para o cronograma de topo
        // Se não tiver marcada como principal, pega a última ativa
        $mainAgenda = Agenda::where('is_main_schedule', true)->first() 
                      ?? Agenda::where('deadline', '>=', now())->orderBy('deadline', 'asc')->first();

        // LISTA DE AGENDAS (Admin vê todas, User vê as vinculadas)
        // Adicionamos a lógica de carregar projetos para contar o progresso
        $votesCountQuery = function ($query) use ($user) {
            $query->where('user_id', $user->id);
        };

        if ($user->role === 'admin') {
            $agendas = Agenda::withCount(['projects', 'votes as user_votes_count' => $votesCountQuery])
                             ->orderBy('deadline', 'desc')
                             ->get();
        } else {
            $agendas = $user->agendas()
                            ->withCount(['projects', 'votes as user_votes_count' => $votesCountQuery])
                            ->orderBy('deadline', 'desc')
                            ->get();
        }

        // CALCULA O PROGRESSO PARA CADA AGENDA
        // Isso preenche o campo ->percentual usado na barra de progresso
        foreach ($agendas as $agenda) {
            // Evita divisão por zero
            $total = $agenda->projects_count;
            $completed = $agenda->user_votes_count;

            $percentual = $total > 0 ? round(($completed / $total) * 100) : 0;
            $agenda->percentual = $percentual;
        }

        return view('user.dashboard', compact('agendas', 'mainAgenda', 'infoText'));
    }

    /**
     * 2. EXPORTAR MEUS VOTOS (Excel)
     * Método adicionado para o botão de download no Dashboard
     */
    public function exportMyVotes($id, $type)
    {
        $agenda = Agenda::findOrFail($id);
        $user = Auth::user();
        
        // Verifica se o usuário tem permissão nessa agenda
        if ($user->role !== 'admin' && !$user->agendas->contains($id)) {
            abort(403, 'Acesso não autorizado a esta agenda.');
        }

        // Nome amigável para o arquivo
        $typeName = ($type === 'agenda') ? 'Agendados' : (($type === 'remanescente') ? 'Remanescentes' : 'Completo');
        $fileName = "Meus_Votos_Agenda{$agenda->year}_{$typeName}.xlsx";

        return Excel::download(new UserVotesExport($id, $user->id, $type), $fileName);
    }
}