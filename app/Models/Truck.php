<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = ['unit_number', 'year', 'notes'];

    // Disables timestamps for this model to not include updated_at, created_at columns while creating a new truck
    public $timestamps = false;
}
