<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = ['name_ar', 'name_en', 'icon'];


    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function nfts(): HasManyThrough
    {
        return $this->hasManyThrough(Nft::class, Collection::class, 'category_id', 'collection_id', 'id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category_icon')->singleFile();
    }


}
