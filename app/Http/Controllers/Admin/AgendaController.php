<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Project;
use App\Models\Vote;
use App\Models\User; 
use App\Imports\ProjectsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\VotedProjectsExport;

class AgendaController extends Controller
{
    // =========================================================================
    // 1. LISTAGEM (DASHBOARD GERAL DE AGENDAS)
    // =========================================================================
    public function index(Request $request)
    {
        $query = Agenda::withCount([
            'projects', // Conta o total geral
            'projects as apresentados_count' => function ($query) {
                $query->where('type', 'agenda'); // Conta apenas Apresentados
            },
            'projects as remanescentes_count' => function ($query) {
                $query->where('type', 'remanescente'); // Conta apenas Remanescentes
            },
        ]);

        // Filtro de Busca
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('year', 'like', "%{$request->search}%");
            });
        }

        // Filtro de Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('deadline', '>=', now());
            } elseif ($request->status === 'closed') {
                $query->where('deadline', '<', now());
            }
        }

        $agendas = $query->orderByRaw('deadline >= NOW() DESC')
            ->orderBy('deadline', 'desc')
            ->paginate(5)
            ->withQueryString();

        // Estatísticas Globais para o Painel
        $stats = [
            'agendas' => Agenda::count(),
            'active_agendas' => Agenda::where('deadline', '>=', now())->count(),
            'projetos' => Project::count(),
            'projetos_agendados' => Project::where('type', 'agenda')->count(),
            'projetos_remanescentes' => Project::where('type', 'remanescente')->count(),
            'votos' => Vote::count(),
            'voters' => Vote::distinct('user_id')->count('user_id'),
        ];

        return view('admin.agendas.index', compact('agendas', 'stats'));
    }

    // =========================================================================
    // 2. CRIAÇÃO
    // =========================================================================
    public function create() {
        $hasMainAgenda = Agenda::where('is_main_schedule', true)->exists();
        $users = User::where('role', 'user')->orderBy('name')->get(); 
        
        return view('admin.agendas.create', compact('hasMainAgenda', 'users'));
    }

    // =========================================================================
    // 3. STORE (Agora salva o caminho do Remanescente)
    // =========================================================================
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'results_date' => 'required|date|after_or_equal:deadline',
            'file_apresentados' => 'required|file|mimes:xlsx,xls,csv',
            'file_remanescentes' => 'required|file|mimes:xlsx,xls,csv|different:file_apresentados',
            'users' => 'required|array|min:1'
        ], [
            'file_remanescentes.different' => 'O arquivo de Remanescentes não pode ser igual ao de Apresentados.',
            'users.required' => 'Selecione pelo menos um participante.',
            'users.min' => 'Selecione pelo menos um participante.',
            'deadline.after_or_equal' => 'A data final deve ser posterior à inicial.',
            'results_date.after_or_equal' => 'A data de resultado deve ser posterior ao fim da votação.'
        ]);

        if ($request->has('is_main_schedule')) {
            Agenda::where('is_main_schedule', true)->update(['is_main_schedule' => false]);
        }

        $agenda = Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'results_date' => $request->results_date,
            'is_main_schedule' => $request->has('is_main_schedule'),
            'allow_editing' => $request->has('allow_editing'),
        ]);

        $agenda->users()->sync($request->users);

        // 1. Upload Apresentados
        if ($request->hasFile('file_apresentados')) {
            try {
                $path = $request->file('file_apresentados')->store('agendas');
                $agenda->file_path = $path;
                $agenda->save();
                Excel::import(new ProjectsImport($agenda->id, 'agenda'), $request->file('file_apresentados'));
            } catch (\Exception $e) { return back()->with('error', 'Erro Apresentados: ' . $e->getMessage()); }
        }

        // 2. Upload Remanescentes (CORRIGIDO: AGORA SALVA O PATH)
        if ($request->hasFile('file_remanescentes')) {
            try {
                $path = $request->file('file_remanescentes')->store('agendas');
                $agenda->file_path_remanescentes = $path; // Salva na coluna nova
                $agenda->save();
                Excel::import(new ProjectsImport($agenda->id, 'remanescente'), $request->file('file_remanescentes'));
            } catch (\Exception $e) { return back()->with('error', 'Erro Remanescentes: ' . $e->getMessage()); }
        }

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda criada com sucesso!');
    }

    // =========================================================================
    // 4. SHOW (LISTA DE PROJETOS E GESTÃO)
    // =========================================================================
    public function show(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        // 1. Carregar listas para os filtros (Select Distinct)
        $temas = $agenda->projects()->select('tema')->distinct()->orderBy('tema')->pluck('tema');
        $subtemas = $agenda->projects()->select('subtema')->distinct()->orderBy('subtema')->pluck('subtema');
        $focos = $agenda->projects()->select('foco')->distinct()->orderBy('foco')->pluck('foco');
        $celulas = $agenda->projects()->select('celula_tematica')->distinct()->orderBy('celula_tematica')->pluck('celula_tematica');
        $autores = $agenda->projects()->select('autor')->distinct()->orderBy('autor')->pluck('autor');
        $partidos = $agenda->projects()->select('partido')->distinct()->orderBy('partido')->pluck('partido');
        $ufs = $agenda->projects()->select('uf')->distinct()->orderBy('uf')->pluck('uf');
        $tipos = $agenda->projects()->select('type')->distinct()->orderBy('type')->pluck('type');
        $interesses = $agenda->projects()->select('interesse')->distinct()->orderBy('interesse')->pluck('interesse');

        // 2. Iniciar Query
        $query = $agenda->projects()->with(['votes.user']);

        // 3. Aplicar Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                    ->orWhere('ementa', 'like', "%{$search}%")
                    ->orWhere('autor', 'like', "%{$search}%")
                    ->orWhere('partido', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('interesse') && $request->interesse !== 'all') {
            $query->where('interesse', $request->interesse);
        }

        if ($request->filled('tema') && $request->tema !== 'all') {
            $query->where('tema', $request->tema);
        }

        if ($request->filled('subtema') && $request->subtema !== 'all') {
            $query->where('subtema', $request->subtema);
        }

        // Paginação
        $projects = $query->paginate(20)->withQueryString();

        return view('admin.agendas.projects', compact('agenda', 'projects', 'temas', 'subtemas', 'focos', 'celulas', 'autores', 'partidos', 'ufs', 'tipos', 'interesses'));
    }

    // =========================================================================
    // 5. DASHBOARD (ESTATÍSTICAS)
    // =========================================================================
    public function dashboard($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->load('projects', 'users');

        $usersData = $agenda->users->map(function ($user) use ($agenda) {
            $totalProjects = $agenda->projects->count();
            $votesCount = Vote::where('user_id', $user->id)
                ->whereIn('project_id', $agenda->projects->pluck('id'))
                ->count();
            $progress = $totalProjects > 0 ? round(($votesCount / $totalProjects) * 100) : 0;

            return (object) [
                'id' => $user->id,
                'name' => $user->name,
                'associacao' => $user->associacao,
                'progress' => $progress,
            ];
        });

        return view('admin.agendas.dashboard', compact('agenda', 'usersData'));
    }

    // =========================================================================
    // 5. EDIÇÃO
    // =========================================================================
    public function edit($id) {
        $agenda = Agenda::findOrFail($id);
        $hasMainAgenda = Agenda::where('is_main_schedule', true)->where('id', '!=', $id)->exists();
        
        $users = User::where('role', 'user')->orderBy('name')->get();
        $selectedUsers = $agenda->users->pluck('id')->toArray(); 

        return view('admin.agendas.edit', compact('agenda', 'hasMainAgenda', 'users', 'selectedUsers'));
    }

    // =========================================================================
    // UPDATE (Salva caminhos corretamente)
    // =========================================================================
    public function update(Request $request, $id) {
        $agenda = Agenda::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:start_date',
            'results_date' => 'required|date|after_or_equal:deadline',
            'users' => 'required|array|min:1',
            'file_remanescentes' => 'nullable|different:file_apresentados',
        ]);

        if ($request->has('is_main_schedule')) {
            Agenda::where('is_main_schedule', true)->where('id', '!=', $id)->update(['is_main_schedule' => false]);
            $agenda->is_main_schedule = true;
        } else {
            $agenda->is_main_schedule = false;
        }

        $agenda->allow_editing = $request->has('allow_editing');
        $agenda->update($request->except(['file_apresentados', 'file_remanescentes', 'is_main_schedule', 'allow_editing', 'users']));
        
        $agenda->users()->sync($request->users);

        // --- SUBSTITUIÇÃO DE ARQUIVOS ---

        // 1. Se enviou novo APRESENTADOS
        if ($request->hasFile('file_apresentados')) {
            try {
                Project::where('agenda_id', $agenda->id)->where('type', 'agenda')->delete();
                $path = $request->file('file_apresentados')->store('agendas');
                $agenda->file_path = $path;
                $agenda->save();
                Excel::import(new ProjectsImport($agenda->id, 'agenda'), $request->file('file_apresentados'));
            } catch (\Exception $e) { return back()->with('error', 'Erro ao atualizar Apresentados: ' . $e->getMessage()); }
        }

        // 2. Se enviou novo REMANESCENTES
        if ($request->hasFile('file_remanescentes')) {
            try {
                Project::where('agenda_id', $agenda->id)->where('type', 'remanescente')->delete();
                // CORRIGIDO: Agora salva o caminho
                $path = $request->file('file_remanescentes')->store('agendas');
                $agenda->file_path_remanescentes = $path;
                $agenda->save();
                Excel::import(new ProjectsImport($agenda->id, 'remanescente'), $request->file('file_remanescentes'));
            } catch (\Exception $e) { return back()->with('error', 'Erro ao atualizar Remanescentes: ' . $e->getMessage()); }
        }

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda atualizada com sucesso!');
    }

    // =========================================================================
    // 6. EXCLUSÃO
    // =========================================================================
    public function destroy($id) {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda excluída.');
    }
    
    // =========================================================================
    // 7. UTILS
    // =========================================================================
    public function checkFile(Request $request) {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls']);
        try {
            $data = Excel::toArray([], $request->file('file'));
            $rowCount = count($data[0]) > 0 ? count($data[0]) - 1 : 0; 
            return response()->json(['success' => true, 'count' => $rowCount, 'message' => "{$rowCount} projetos encontrados."]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        }
    }

    public function resetUserVotes($agendaId, $userId) {
        $agenda = Agenda::findOrFail($agendaId);
        $projectIds = $agenda->projects()->pluck('id');
        Vote::where('user_id', $userId)->whereIn('project_id', $projectIds)->delete();
        return back()->with('success', 'Votos resetados com sucesso.');
    }

    // =========================================================================
    // 8. DOWNLOADS (CORRIGIDO PARA ACEITAR TIPO)
    // =========================================================================
    public function download($id, $type) {
        $agenda = Agenda::findOrFail($id);
        
        $path = null;
        $name = 'arquivo.xlsx';

        if ($type === 'remanescente') {
            $path = $agenda->file_path_remanescentes;
            $name = "Projetos_Remanescentes_{$agenda->year}.xlsx";
        } else {
            $path = $agenda->file_path;
            $name = "Projetos_Apresentados_{$agenda->year}.xlsx";
        }
        
        if ($path && Storage::exists($path)) {
            return Storage::download($path, $name);
        }
        
        return back()->with('error', 'Arquivo não encontrado no servidor. Tente enviar novamente na edição.');
    }

    // =========================================================================
    // 9. RELATÓRIOS
    // =========================================================================
    public function report($id) {
        $agenda = Agenda::findOrFail($id);
        
        $projects = Project::where('agenda_id', $id)
            ->whereHas('votes')
            ->with(['votes.user'])
            ->get()
            ->map(function($project) {
                // Estatísticas Baseadas em 'posicao' e 'ressalva'
                $convergentes = $project->votes->where('posicao', 'Convergente');
                $divergentes  = $project->votes->where('posicao', 'Divergente');
                
                $stats = [
                    'convergente' => $convergentes->count(),
                    'divergente' => $divergentes->count(),
                    // Prioridades
                    'agenda' => $project->votes->where('prioridade', 'Agenda')->count(),
                    'alta' => $project->votes->where('prioridade', 'Alta')->count(),
                    'media' => $project->votes->where('prioridade', 'Média')->count(),
                    'baixa' => $project->votes->where('prioridade', 'Baixa')->count(),
                ];

                $ressalvas = $project->votes
                    ->filter(fn($v) => !empty($v->ressalva))
                    ->map(function($vote) {
                        $empresa = $vote->user->associacao ?? 'Empresa não informada';
                        return "<strong>({$empresa})</strong> - {$vote->ressalva}";
                    });

                $project->stats = $stats;
                $project->formatted_ressalvas = $ressalvas;
                return $project;
            });

        return view('admin.agendas.report', compact('agenda', 'projects'));
    }
    // =========================================================================
    // 10. EXPORTAÇÃO EXCEL
    // =========================================================================
    public function exportExcel($id, $type) {
        // Valida o tipo
        if (!in_array($type, ['apresentados', 'remanescentes', 'geral'])) {
            return back()->with('error', 'Tipo de relatório inválido.');
        }

        $agenda = Agenda::findOrFail($id);
        $fileName = "Relatorio_{$type}_{$agenda->year}.xlsx";

        return Excel::download(new VotedProjectsExport($id, $type), $fileName);
    }

}