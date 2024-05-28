<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $table = 'budget';

    protected $fillable = [
        'annee',
        'id_rubric',
        'montant_prevue',
        'montant_depose',
    ];

    public function rubric()
    {
        return $this->belongsTo(Rubric::class, 'id_rubric');
    }
}
