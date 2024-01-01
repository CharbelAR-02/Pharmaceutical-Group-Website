<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacist;
use App\Models\Depot;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    protected $table = 'pharmacies';

    public function pharmacists()
    {
        return $this->hasMany(Pharmacist::class);
    }

    public function depot()
    {
        return $this->hasOne(Depot::class);
    }
}
