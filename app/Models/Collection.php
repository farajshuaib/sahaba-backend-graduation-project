<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'banner_image', 'category_id', 'facebook_url', 'instagram_url', 'logo_image', 'is_sensitive_content', 'collection_token_id', 'twitter_url', 'website_url'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
        return $this->belongsToMany(User::class, 'collection_collaborators', 'user_id', 'collection_id');
    }

    public function nfts(): HasMany
    {
        return $this->hasMany(Nft::class);
    }
}
