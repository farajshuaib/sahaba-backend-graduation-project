<?php

namespace App\Models;

use App\QueryFilters\Reports\Reportable;
use App\QueryFilters\Reports\ReportableId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Pipeline\Pipeline;

class Report extends Model
{
    protected $guarded = [];

    public static function withFilters()
    {
        return app(Pipeline::class)
            ->send(self::query())
            ->through([
                Reportable::class,
                ReportableId::class
            ])
            ->thenReturn()
            ->with('user')->paginate(10);

    }


    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
