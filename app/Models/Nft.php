<?php

namespace App\Models;

use App\QueryFilters\Nfts\Search;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Pipeline\Pipeline;
use Overtrue\LaravelLike\Traits\Likeable;

class Nft extends Model
{
    use Likeable, HasFactory;


    protected $fillable = ['title', 'description', 'collection_id', 'user_id', 'creator_address', 'file_path', 'price', 'is_for_sale', 'sale_end_at', 'file_type', 'nft_token_id'];

    protected $casts = ['is_for_sale' => 'boolean'];

    public static function withFilters()
    {
        return app(Pipeline::class)
            ->send(Nft::query())
            ->through([
                Search::class,
                \App\QueryFilters\Nfts\Collection::class,
                \App\QueryFilters\Nfts\Category::class,
            ])
            ->thenReturn()
            ->with('collection', 'user', 'user.likes.likeable')
            ->orderBy('id', 'DESC')
            ->paginate(15);
    }

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

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
