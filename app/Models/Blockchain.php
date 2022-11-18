<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blockchain extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $fillable = ['id', 'name', 'symbol', 'rpc_url', 'explorer_url'];

    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class);
    }

    public function nfts(): HasManyThrough
    {
        return $this->hasManyThrough(Nft::class, Collection::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

}