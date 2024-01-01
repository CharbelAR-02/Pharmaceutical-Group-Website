<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pharmacist;
use App\Models\Customer;
use App\Models\Medication;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total_price',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class);
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'command_medications')
            ->withPivot('id', 'quantity', 'unit_price', 'item_total', 'medication_id')
            ->withTimestamps();
    }
}
