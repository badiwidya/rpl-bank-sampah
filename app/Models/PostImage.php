<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    protected $guarded = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
