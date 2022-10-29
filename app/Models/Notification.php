<?php

namespace App\Models;

use App\QueryFilters\Notifications\Read;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pipeline\Pipeline;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'notifiable_type', 'notifiable_id', 'data', 'user_id', 'read_at'];

    protected $dates = ['read_at'];

    public static function withFilters()
    {
        return app(Pipeline::class)
            ->send(Notification::query())
            ->through([
                Read::class,
            ])
            ->thenReturn()
            ->where('user_id', auth()->id())
            ->orderBy('id', 'DESC');
    }

    public function notifiable()
    {
        $this->morphTo();
    }
}
