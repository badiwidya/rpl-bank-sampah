<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogHargaSampah extends Model
{
    protected $table = 'log_harga_sampah';

    protected $guarded = [];

    public function sampah(): BelongsTo
    {
        return $this->belongsTo(Sampah::class, 'sampah_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
