<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    ];

    public $timestamps = false;

    public function location() : BelongsTo
    {
        return $this -> belongsTo(Location::class, 'home');
    }

    public function user() : BelongsTo
    {
        return $this -> belongsTo(User::class, 'info_personal');
    }

    public function applications() : HasMany
    {
        return $this -> HasMany(Application::class, 'client');
    }

    public function ratings() : HasMany
    {
        return $this -> HasMany(Rating::class, 'client');
    }

    public function messages() : HasMany
    {
        return $this -> HasMany(Message::class, 'client');
    }

    public function contracts() : HasMany
    {
        return $this -> HasMany(Contract::class, 'client');
    }

    public function verifyingAdministrator() : BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'verified_by');
    }
}
