<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Overtrue\LaravelLike\Traits\Likeable;

class Nft extends Model
{
    use Likeable, HasFactory;


    protected $fillable = ['title', 'description', 'collection_id', 'user_id', 'creator_address', 'file_url', 'price', 'is_for_sale', 'sale_end_at', 'file_type', 'nft_token_id'];

    protected $casts = ['is_for_sale' => 'boolean'];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(NftHistory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): HasOneThrough
    {
        return $this->hasOneThrough(Collection::class, Category::class);
    }


    public function scopeIsPublished($query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeIsOwner($query): Builder
    {
        return $query->where('user_id', auth()->id());
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }


}
