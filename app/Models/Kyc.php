<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kyc extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = ['gender', 'country', 'city', 'address', 'phone_number', 'author_type', 'author_art_type', 'passport_id', 'user_id'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statistics(): array
    {
        return [
            'total' => $this->count(),
            'approved' => $this->where('status', 'approved')->count(),
            'rejected' => $this->where('status', 'rejected')->count(),
            'pending' => $this->where('status', 'pending')->count(),
        ];
    }
}
