<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
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

    public function applications() : BelongsToMany
    {
        return $this -> belongsToMany(Application::class, 'suppliers_applications');
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
