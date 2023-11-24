<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];
}
