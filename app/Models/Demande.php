<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $table = 'demande';

    protected $fillable = [
        'annee',
        'status',
        'description',
        'type',
        'montant',
        'id_budget',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'id_budget');
    }
}
