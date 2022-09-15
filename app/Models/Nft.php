<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Nft extends Model
{
    use Likeable;

    public function category():  \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function collection(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function transfers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NftHistory::class);
    }

    public function scopeIsApproved($query): Builder
    {
        return $query->where('status', 'approved');
    }


}
