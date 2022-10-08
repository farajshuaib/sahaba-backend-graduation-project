<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasFactory;

    protected $fillable = ['nft_id', 'from', 'to', 'price', 'type'];


    public function from(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function nft(): BelongsTo
    {
        return $this->belongsTo(Nft::class, 'nft_id', 'id');
    }
}
