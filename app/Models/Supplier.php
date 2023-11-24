<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable_2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Application;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Authenticatable_2
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner',
        'description',
        'phone',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function applications()
    {
        return $this -> belongsToMany(Application::class, 'supplier_applications', 'provider', 'publishing')->withPivot('status');
    }

    public function location() : BelongsTo
    {
        return $this -> belongsTo(Location::class, 'company');
    }

    public function ratings() : HasMany
    {
        return $this -> HasMany(Rating::class, 'provider');
    }

    public function messages() : HasMany
    {
        return $this -> HasMany(Message::class, 'provider');
    }

    public function contracts() : HasMany
    {
        return $this -> HasMany(Contract::class, 'provider');
    }
}
