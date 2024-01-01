<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacy;
use App\Models\Medication;

class Depot extends Model
{
    use HasFactory;

    protected $table = 'depots';

    protected $fillable = [
        'pharmacy_id',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'depot_medications')
            ->withPivot('quantity', 'price', 'medication_id')
            ->withTimestamps();
    }
}
