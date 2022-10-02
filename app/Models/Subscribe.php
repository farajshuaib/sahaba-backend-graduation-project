<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscribe extends Model
{
    protected $fillable = ['user_id', 'email'];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
