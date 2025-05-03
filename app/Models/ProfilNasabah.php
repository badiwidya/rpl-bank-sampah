<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilNasabah extends Model
{
    protected $table = 'profil_nasabah';

    protected $guarded = [ 'saldo' ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
