<?php

namespace App\Models;

use App\QueryFilters\Transactions\From;
use App\QueryFilters\Transactions\To;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;


class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasFactory;

    protected $fillable = ['nft_id', 'from', 'to', 'price', 'type', 'tx_hash'];

    protected $casts = [
        'price' => 'float'
    ];

    public static function withFilters()
    {
        return app(Pipeline::class)
            ->send(Transaction::query())
            ->through([
                \App\QueryFilters\Transactions\Nft::class,
                From::class,
                To::class,
            ])
            ->thenReturn()
            ->with('fromUser', 'toUser', 'nft');

    }


    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }

    public function nft(): BelongsTo
    {
        return $this->belongsTo(Nft::class, 'nft_id', 'id');
    }
}
