<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'icon'];


    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function nfts(): HasManyThrough
    {
        return $this->hasManyThrough(Collection::class, Nft::class, 'collection_id', 'category_id', 'id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_icon')->singleFile();
    }


}
