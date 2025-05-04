<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'password',
        'role',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function generateVerificationUrl()
    {
        return URL::temporarySignedRoute(
            'mail.verification.verify',
            now()->addMinutes(50),
            [
                'hash' => hash('sha256', $this->email),
                'id' => $this->id,
            ]
        );
    }

    public function profile(): HasOne
    {
        return $this->hasOne(ProfilNasabah::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function transaksiPenarikan(): HasMany
    {
        return $this->hasMany(TransaksiPenarikan::class);
    }

    public function transaksiPenukaran(): HasMany
    {
        return $this->hasMany(TransaksiPenukaran::class);
    }
}
