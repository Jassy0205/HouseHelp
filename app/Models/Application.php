<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function suppliers() : BelongsToMany
    {
        return $this -> belongsToMany(Supplier::class, 'suppliers_applications');
    }
}
