<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VotedProjectsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $agendaId;
    protected $type;

    public function __construct($agendaId, $type)
    {
        $this->agendaId = $agendaId;
        $this->type = $type; // 'agenda', 'remanescente', ou 'geral'
    }

    public function collection()
    {
        $query = Project::where('agenda_id', $this->agendaId)
            ->whereHas('votes') // APENAS PROJETOS COM VOTOS
            ->with('votes');

        // Se não for geral, filtra pelo tipo específico
        if ($this->type !== 'geral') {
            // Se type for 'apresentados', buscamos 'agenda' no banco
            // Se type for 'remanescentes', buscamos 'remanescente' no banco
            $dbType = ($this->type === 'apresentados') ? 'agenda' : 'remanescente';
            $query->where('type', $dbType);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Proposição Completa',
            'Autor',
            'Partido',
            'UF',
            'Foco',
            'Prioridade',
            'Tema',
            'Subtema',
            'Célula Temática',
            'Órgão Origem',
            'Situação',
            'Regime Tramitação',
            'Link',
            // Colunas Extras de Resultado
            'Votos Convergentes',
            'Votos C/ Ressalva',
            'Votos Divergentes',
            'Abstenções',
            'Total Votos'
        ];
    }

    public function map($project): array
    {
        // Calcular totais
        $convergente = $project->votes->where('vote_value', 'Convergente')->count();
        $ressalva = $project->votes->where('vote_value', 'Convergente com Ressalva')->count();
        $divergente = $project->votes->where('vote_value', 'Divergente')->count();
        $abstencao = $project->votes->where('vote_value', 'Abstenção')->count();
        $total = $project->votes->count();

        return [
            $project->codigo,
            $project->autor,
            $project->partido,
            $project->uf,
            $project->foco,
            $project->prioridade_original,
            $project->tema,
            $project->subtema,
            $project->celula_tematica,
            $project->orgao_origem,
            $project->situacao,
            $project->regime_tramitacao,
            $project->link_pdf,
            // Dados calculados
            $convergente,
            $ressalva,
            $divergente,
            $abstencao,
            $total
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Cabeçalho em negrito
        ];
    }
}