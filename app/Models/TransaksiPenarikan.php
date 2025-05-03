<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPenarikan extends Model
{
    protected $table = 'transaksi_penarikan';

    protected $guarded = [];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
