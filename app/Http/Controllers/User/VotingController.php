<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;
use App\Models\Project;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    /**
     * Exibe a página de votação (Lista de Projetos da Agenda)
     */
    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $agenda = Agenda::findOrFail($id);

        // Query principal de projetos vinculados à agenda
        $query = Project::where('agenda_id', $id)
            ->with(['votes' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }]);

        // ==================================================
        // 1. APLICAÇÃO DOS FILTROS
        // ==================================================

        // Busca Textual (Código, Ementa, Autor)
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                $q->where('codigo', 'like', "%{$term}%")
                  ->orWhere('ementa', 'like', "%{$term}%")
                  ->orWhere('autor', 'like', "%{$term}%");
            });
        }

        // Filtro: Interesse (ex: Alto, Médio, Baixo - se existir no projeto)
        if ($request->filled('interesse')) {
            $query->where('interesse', $request->interesse);
        }

        // Filtro: Tema
        if ($request->filled('tema')) {
            $query->where('tema', $request->tema);
        }

        // Filtro: Subtema
        if ($request->filled('subtema')) {
            $query->where('subtema', $request->subtema);
        }

        // Filtro: Tipo/Origem (Agendado vs Remanescente)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtro: Status de Votação (Pendente / Votado)
        if ($request->filled('status')) {
            if ($request->status == 'votado') {
                $query->whereHas('votes', function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->whereNotNull('prioridade') // Ajuste se seu banco usa 'vote_value'
                      ->whereNotNull('posicao');
                });
            } elseif ($request->status == 'pendente') {
                $query->whereDoesntHave('votes', function($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->whereNotNull('prioridade')
                      ->whereNotNull('posicao');
                });
            }
        }

        // ==================================================
        // 2. CARREGAMENTO DE DADOS PARA OS DROPDOWNS
        // ==================================================
        
        // Pega apenas valores únicos existentes nesta agenda para não mostrar filtros vazios
        // OTIMIZAÇÃO: Combina 3 queries em 1 usando UNION ALL para evitar round trips desnecessários
        $results = Project::select('tema as value', DB::raw("'temas' as type"))
            ->where('agenda_id', $id)
            ->whereNotNull('tema')
            ->distinct()
            ->toBase()
            ->unionAll(
                Project::select('subtema as value', DB::raw("'subtemas' as type"))
                    ->where('agenda_id', $id)
                    ->whereNotNull('subtema')
                    ->distinct()
                    ->toBase()
            )
            ->unionAll(
                Project::select('interesse as value', DB::raw("'interesses' as type"))
                    ->where('agenda_id', $id)
                    ->whereNotNull('interesse')
                    ->distinct()
                    ->toBase()
            )
            ->get();

        $filters = [
            'temas' => $results->where('type', 'temas')->pluck('value')->sort(),
            'subtemas' => $results->where('type', 'subtemas')->pluck('value')->sort(),
            'interesses' => $results->where('type', 'interesses')->pluck('value')->sort(),
        ];

        // Paginação (Mantém os filtros na URL ao mudar de página)
        $projects = $query->paginate(10)->withQueryString();

        // Dados de Progresso
        $progressData = $this->calculateProgress($agenda, $user->id);

        return view('user.voting.index', compact('agenda', 'projects', 'progressData', 'filters'));
    }

    /**
     * Salva o voto via AJAX
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = Auth::user();
        
        // Sanitização: Converte string "null" do JS para null real do PHP
        $prioridade = ($request->prioridade === 'null' || $request->prioridade === '') ? null : $request->prioridade;
        $posicao    = ($request->posicao === 'null' || $request->posicao === '') ? null : $request->posicao;
        $ressalva   = ($request->ressalva === 'null') ? null : $request->ressalva;

        // Atualiza ou Cria o Voto
        // ATENÇÃO: Verifique se os nomes das colunas no banco são 'prioridade' ou 'vote_value'
        // Estou usando 'prioridade' e 'ressalva' baseado no seu último feedback da view.
        Vote::updateOrCreate(
            ['user_id' => $user->id, 'project_id' => $request->project_id],
            [
                'prioridade' => $prioridade, 
                'posicao'    => $posicao,
                'ressalva'   => $ressalva    
            ]
        );

        // Recalcula progresso
        $project = Project::find($request->project_id);
        $agenda = Agenda::find($project->agenda_id);
        $newProgress = $this->calculateProgress($agenda, $user->id);

        // Define status para retorno visual (muda a cor do badge na hora)
        $status = 'pendente';
        if ($prioridade && $posicao) {
            $status = 'complete';
        } elseif ($prioridade || $posicao) {
            $status = 'incomplete';
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'newPercent' => $newProgress['percent']
        ]);
    }

    /**
     * Remove o voto do banco de dados (Limpar Voto)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = Auth::user();

        // Deleta o voto se existir
        Vote::where('user_id', $user->id)
            ->where('project_id', $request->project_id)
            ->delete();

        // Recalcula progresso
        $project = Project::find($request->project_id);
        $agenda = Agenda::find($project->agenda_id);
        $newProgress = $this->calculateProgress($agenda, $user->id);

        return response()->json([
            'success' => true,
            'newPercent' => $newProgress['percent']
        ]);
    }

    /**
     * Auxiliar: Calcula progresso
     */
    private function calculateProgress($agenda, $userId) {
        $total = Project::where('agenda_id', $agenda->id)->count();
        
        $completed = Vote::where('user_id', $userId)
            ->whereIn('project_id', function($q) use ($agenda) {
                $q->select('id')->from('projects')->where('agenda_id', $agenda->id);
            })
            ->whereNotNull('prioridade')
            ->whereNotNull('posicao')
            ->count();

        $percent = $total > 0 ? round(($completed / $total) * 100) : 0;

        return ['percent' => $percent, 'total' => $total, 'completed' => $completed];
    }
}