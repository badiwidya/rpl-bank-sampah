<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, PasswordsCanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
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

    public function generateVerificationUrl($email = null)
    {
        return URL::temporarySignedRoute(
            'mail.verification.verify',
            now()->addMinutes(50),
            [
                'value' => $email ?? hash('sha256', $this->email),
                'id' => $this->id,
            ]
        );
    }

    public function sendPasswordResetNotification($token)
    {

        $url = url(route('auth.password.reset', ['token' => $token, 'email' => $this->email], false));

        return $this->notify(new \App\Notifications\ResetPassword($url));
    }

    public function profile(): HasOne
    {
        return $this->hasOne(ProfilNasabah::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function transaksiPenarikan(): HasMany
    {
        return $this->hasMany(TransaksiPenarikan::class);
    }

    public function transaksiPenukaran(): HasMany
    {
        return $this->hasMany(TransaksiPenukaran::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LogHargaSampah::class, 'user_id');
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value) {
                return $value
                    ? 'storage/' . $value
                    : 'avatars/default.png';
            }
        );
    }
}
