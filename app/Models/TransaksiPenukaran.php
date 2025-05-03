<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPenukaran extends Model
{
    protected $table = 'transaksi_penukaran';

    protected $guarded = [
        'total_berat',
        'total_harga',
    ];

    public function nasabah(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
