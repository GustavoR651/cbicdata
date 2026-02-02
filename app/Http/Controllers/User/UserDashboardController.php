<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserVotesExport; // Importe sua classe de exportação
use App\Models\Agenda;
use App\Models\Project;
use App\Models\Vote;
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
        if ($user->role === 'admin') {
            $agendas = Agenda::withCount('projects')
                             ->orderBy('deadline', 'desc')
                             ->get();
        } else {
            $agendas = $user->agendas()
                            ->withCount('projects')
                            ->orderBy('deadline', 'desc')
                            ->get();
        }

        // CALCULA O PROGRESSO PARA CADA AGENDA
        // Isso preenche o campo ->percentual usado na barra de progresso
        foreach ($agendas as $agenda) {
            $this->calculateProgress($agenda, $user->id);
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

    /**
     * 3. MÉTODO AUXILIAR: CALCULAR PROGRESSO
     * Conta quantos projetos o usuário já votou (Prioridade + Posição preenchidos)
     */
    private function calculateProgress($agenda, $userId) {
        // Total de projetos na agenda
        $total = Project::where('agenda_id', $agenda->id)->count();
        
        // Total votado pelo usuário (Voto completo)
        // Considera voto válido se tiver Prioridade E Posição (ajuste conforme sua regra)
        // Se basta votar em um campo, remova o whereNotNull extra.
        $completed = Vote::where('user_id', $userId)
            ->whereIn('project_id', function($q) use ($agenda) {
                $q->select('id')->from('projects')->where('agenda_id', $agenda->id);
            })
            // ->whereNotNull('prioridade') // Descomente se prioridade for obrigatória
            // ->whereNotNull('posicao')    // Descomente se posição for obrigatória
            ->count();

        // Evita divisão por zero
        $percentual = $total > 0 ? round(($completed / $total) * 100) : 0;
        
        // Injeta o atributo no objeto agenda para a View usar
        $agenda->percentual = $percentual;

        return [
            'percent' => $percentual, 
            'total' => $total, 
            'completed' => $completed
        ];
    }
}