<?php

namespace App\Imports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectsImport implements ToModel, WithHeadingRow
{
    private $agenda_id;
    private $type; // <--- NOVA PROPRIEDADE

    // Atualizado para receber o ID e o TIPO
    public function __construct($agenda_id, $type = 'agenda') {
        $this->agenda_id = $agenda_id;
        $this->type = $type;
    }

    public function model(array $row)
    {
        // 1. Verificação básica de integridade
        if (!isset($row['proposicao_completa'])) {
            return null;
        }

        // 2. Criação do Projeto
        return new Project([
            'agenda_id'           => $this->agenda_id,
            'type'                => $this->type, // <--- SALVANDO O TIPO AQUI
            
            // Mapeamento das colunas do Excel
            'codigo'              => $row['proposicao_completa'],
            'autor'               => $row['autor'] ?? null,
            'partido'             => $row['partido_do_autor'] ?? null,
            'uf'                  => $row['uf_do_autor'] ?? null,
            'foco'                => $row['foco'] ?? null,
            'prioridade_original' => $row['prioridade'] ?? null,
            'interesse'           => $row['interesse'] ?? null,
            'tema'                => $row['tema'] ?? null,
            'subtema'             => $row['subtema'] ?? null,
            'celula_tematica'     => $row['celula_tematica'] ?? null,
            'orgao_origem'        => $row['orgao_de_origem'] ?? null,
            
            // Campos de Status/Tramitação
            'posicao_recente'     => $row['posicao_mais_recente'] ?? null,
            'referencia_posicao'  => $row['referencia_da_posicao'] ?? null,
            'localizacao_atual'   => $row['localizacao_atual'] ?? null,
            'situacao'            => $row['situacao'] ?? null,
            'tipo_resultado'      => $row['tipo_de_resultado'] ?? null,
            'tipo_forma'          => $row['tipo_de_forma'] ?? null,
            'regime_tramitacao'   => $row['regime_de_tramitacao'] ?? null,
            'ementa'              => $row['ementa'] ?? null,
            'orgao_localizacao'   => $row['orgao_da_localizacao_atual'] ?? null,
            'link_pdf'            => $row['link_da_proposicao'] ?? null,
        ]);
    }
}