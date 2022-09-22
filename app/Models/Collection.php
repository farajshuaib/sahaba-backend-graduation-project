<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Collection extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description', 'category_id', 'facebook_url', 'telegram_url', 'twitter_url', 'website_url', 'is_sensitive_content', 'collection_token_id', 'user_id'];

    protected $casts = ['is_sensitive_content' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collection_collaborators', 'collection_id', 'user_id');
    }


    public function nfts(): HasMany
    {
        return $this->hasMany(Nft::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('collection_banner_image')->singleFile();
        $this->addMediaCollection('collection_logo_image')->singleFile();
    }
}
