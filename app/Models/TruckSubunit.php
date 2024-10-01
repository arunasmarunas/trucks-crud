<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckSubunit extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = ['main_truck', 'subunit', 'start_date', 'end_date'];

    // Disables timestamps for this model to not include updated_at, created_at columns while creating a new truck
    public $timestamps = false;

    // Define relationships (Optional, if needed)
    public function truck()
    {
        return $this->belongsTo(Truck::class, 'main_truck');
    }
}
