<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function suppliers()
    {
        return $this -> belongsToMany(Supplier::class, 'supplier_applications', 'publishing', 'provider')->withPivot('status');
    }

    public function customer() : BelongsTo
    {
        return $this -> belongsTo(Customer::class, 'client');
    }
}
