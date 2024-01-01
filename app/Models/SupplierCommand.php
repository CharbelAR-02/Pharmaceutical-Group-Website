<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Medication;

class SupplierCommand extends Model
{
    use HasFactory;

    protected $table = 'supplier_commands';

    protected $fillable = [
        'status',
        'total_price',
        'supplier_id',
    ];

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'supplier_command_medications')
            ->withPivot('id', 'quantity', 'medication_id')
            ->withTimestamps();
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
