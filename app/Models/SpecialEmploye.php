<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SpecialEmploye extends Model
{
    use HasFactory;

    protected $table = 'special_employes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
