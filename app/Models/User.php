<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, Liker, HasRoles, Follower, Followable, InteractsWithMedia, SoftDeletes;

    protected $guarded = [];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean'
    ];


    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_collaborators', 'user_id', 'collection_id');
    }

    public function created_nfts(): HasMany
    {
        return $this->hasMany(Nft::class, 'creator_id');
    }

    public function owned_nfts(): HasMany
    {
        return $this->hasMany(Nft::class, 'owner_id');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function watching(): HasMany
    {
        return $this->hasMany(Watch::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('users_profile')->singleFile();
    }

    public function subscribe(): HasOne
    {
        return $this->hasOne(Subscribe::class);
    }

    public function scopeIsEnabled($query)
    {
        return $query->where('status', 'enabled');
    }
}
