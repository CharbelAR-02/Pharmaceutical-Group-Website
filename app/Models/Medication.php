<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Depot;
use App\Models\Command;
use App\Models\BaseDepot;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'medications';

    protected $fillable = [
        'name',
        'category',
        'state',
    ];

    public function depots()
    {
        return $this->belongsToMany(Depot::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function commands()
    {
        return $this->belongsToMany(Command::class)
            ->withPivot('quantity', 'unit_price', 'item_total')
            ->withTimestamps();
    }
    public function BaseDepot()
    {
        return $this->hasOne(BaseDepot::class);
    }
}
