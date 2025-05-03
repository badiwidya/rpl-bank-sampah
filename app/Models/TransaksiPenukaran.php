<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function sampah(): BelongsToMany
    {
        return $this->belongsToMany(
            Sampah::class,
            'transaksi_penukaran_sampah',
            'transaksi_penukaran_id',
            'sampah_id'
        )
            ->withPivot(['berat', 'harga_subtotal']);
    }
}
