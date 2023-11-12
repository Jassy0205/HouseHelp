<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function supplier() : BelongsTo
    {
        return $this -> belongsTo(Supplier::class, 'provider');
    }

    public function customer() : BelongsTo
    {
        return $this -> belongsTo(Customer::class, 'client');
    }
}
