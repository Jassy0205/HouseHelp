<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Application;

class Administrator extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public $timestamps = false;

    public function user() : BelongsTo
    {
        return $this -> belongsTo(User::class, 'info_personal');
    }

    public function verifiedCustomers() : HasMany
    {
        return $this->hasMany(Customer::class, 'verified_by');
    }

    public function verifiedSuppliers() : HasMany
    {
        return $this->hasMany(Supplier::class, 'verified_by');
    }
}
