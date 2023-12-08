<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'department',
        'address',
        'neighborhood',
        'specifications',
    ];

    public function users() : HasMany
    {
        return $this -> HasMany(User::class, 'home');
    }

    public function suppliers() : HasMany
    {
        return $this -> HasMany(Supplier::class, 'company');
    }
}
