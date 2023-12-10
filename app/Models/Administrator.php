<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable_2
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Application;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrator extends Authenticatable_2
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user has the administrator role.
     *
     * @return bool
     */
    public function isAdmin()
    {
        // Implement your logic to check if the user has the administrator role.
        // This could involve checking a 'role' column in your administrators table.
        // For example:
        return $this->type === 'admin';
    }

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
