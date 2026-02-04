<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'user_id', 
        'project_id', 
        'prioridade', 
        'posicao', 
        'ressalva'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
