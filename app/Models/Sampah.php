<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sampah extends Model
{
    protected $table = 'sampah';

    protected $guarded = [];

    public function transaksiPenukaran(): BelongsToMany
    {
        return $this->belongsToMany(
            TransaksiPenukaran::class,
            'transaksi_penukaran_sampah',
            'sampah_id',
            'transaksi_penukaran_id'
        )
            ->withPivot(['berat', 'harga_subtotal']);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                return 'storage/' . $value;
            }
        );
    }
}
