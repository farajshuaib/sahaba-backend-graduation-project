<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Watch extends Model
{
    protected $fillable = ['nft_id', 'user_id'];
    use HasFactory;

    public function watchers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function watching(): BelongsToMany
    {
        return $this->belongsToMany(Nft::class);
    }
}
