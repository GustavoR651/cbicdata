<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'associacao', 
        'cargo', 
        'telefone',
        'password',
        'role',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // RELACIONAMENTOS
    // ==========================================

    // Relacionamento com Agendas (Muitos para Muitos)
    public function agendas() {
        return $this->belongsToMany(Agenda::class, 'agenda_user');
    }

    // Relacionamento com Votos (Um para Muitos) - [CORREÇÃO AQUI]
    public function votes() {
        return $this->hasMany(Vote::class);
    }

    // ==========================================
    // HELPERS
    // ==========================================

    // Helper para saber se é admin
    public function isAdmin() {
        return $this->role === 'admin';
    }
}