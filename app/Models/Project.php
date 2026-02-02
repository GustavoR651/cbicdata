<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'type', // <--- OBRIGATÓRIO PARA SEPARAR AGENDADOS DE REMANESCENTES
        
        'codigo',
        'autor',
        'partido',
        'uf',
        'ementa',
        'foco',
        'interesse',
        'tema',
        'subtema',           // Faltava
        'celula_tematica',   // Faltava
        'orgao_origem',      // Faltava
        'posicao_recente',   // Faltava
        'referencia_posicao',// Faltava
        'localizacao_atual',
        'situacao',
        'tipo_resultado',    // Faltava
        'tipo_forma',        // Faltava
        'regime_tramitacao', // Faltava
        'orgao_localizacao', // Faltava
        'link_pdf',
        'prioridade_original' // Faltava
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}