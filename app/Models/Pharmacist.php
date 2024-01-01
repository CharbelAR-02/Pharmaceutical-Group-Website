<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Command;

class Pharmacist extends Model
{
    use HasFactory;

    protected $table = 'pharmacists';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}
