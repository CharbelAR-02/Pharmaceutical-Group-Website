<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medication;

class BaseDepot extends Model
{
    use HasFactory;

    protected $table = 'base_depot_medications';

    protected $fillable = [
        'quantity',
        'price',
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
