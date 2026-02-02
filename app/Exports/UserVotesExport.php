<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\Vote;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class UserVotesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $agendaId;
    protected $userId;
    protected $type;

    public function __construct($agendaId, $userId, $type)
    {
        $this->agendaId = $agendaId;
        $this->userId = $userId;
        $this->type = $type;
    }

    public function collection()
    {
        // Busca os projetos da agenda específica
        $query = Project::where('agenda_id', $this->agendaId);

        // Filtra por tipo (agendado ou remanescente), se não for 'all'
        if ($this->type !== 'all') {
            $query->where('type', $this->type);
        }

        // Carrega os votos SOMENTE deste usuário para esses projetos
        $projects = $query->with(['votes' => function($q) {
            $q->where('user_id', $this->userId);
        }])->get();

        // Filtra apenas projetos que o usuário votou (opcional, remova se quiser baixar tudo mesmo sem voto)
        // Se quiser baixar TUDO e mostrar vazio onde não votou, mantenha. 
        // Se quiser baixar só o que votou, use ->filter(...)
        
        return $projects;
    }

    public function headings(): array
    {
        return [
            'Código',
            'Origem',
            'Ementa',
            'Minha Prioridade',
            'Minha Posição',
            'Meu Comentário/Ressalva',
            'Data do Voto'
        ];
    }

    public function map($project): array
    {
        // Pega o voto do usuário (se existir)
        $vote = $project->votes->first();

        return [
            $project->codigo,
            ucfirst($project->type),
            $project->ementa,
            $vote ? $vote->vote_value : 'Não Votado', // Ex: Alta, Média...
            $vote ? $vote->posicao : '-',             // Ex: Convergente, Divergente
            $vote ? $vote->comment : '-',
            $vote ? $vote->created_at->format('d/m/Y H:i') : '-'
        ];
    }
}