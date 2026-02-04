<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'year',
        'start_date',
        'deadline',
        'results_date',
        'is_main_schedule',
        'allow_editing',
        'file_path',               // Caminho do arquivo 'Apresentados'
        'file_path_remanescentes'  // Caminho do arquivo 'Remanescentes' (Novo)
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline' => 'datetime',
        'results_date' => 'datetime',
        'is_main_schedule' => 'boolean',
        'allow_editing' => 'boolean',
    ];

    // Relação: Todos os projetos da agenda (Misto)
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // HELPER: Apenas projetos do tipo 'agenda' (Apresentados)
    public function apresentados(): HasMany
    {
        return $this->hasMany(Project::class)->where('type', 'agenda');
    }

    // HELPER: Apenas projetos do tipo 'remanescente'
    public function remanescentes(): HasMany
    {
        return $this->hasMany(Project::class)->where('type', 'remanescente');
    }

    // Relação: Participantes vinculados
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'agenda_user');
    }

    // Relação: Votos vinculados através de projetos
    public function votes(): HasManyThrough
    {
        return $this->hasManyThrough(Vote::class, Project::class);
    }
}