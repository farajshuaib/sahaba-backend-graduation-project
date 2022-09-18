<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'banner_image', 'category_id', 'facebook_url', 'instagram_url', 'logo_image', 'is_sensitive_content', 'telegram_url', 'twitter_url', 'website_url'];


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function collabraters()
    {
        return $this->belongsToMany(User::class, 'collection_collaborators', 'collection_id', 'user_id');
    }
}
