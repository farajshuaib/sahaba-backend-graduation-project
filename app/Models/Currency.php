<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'symbol', 'decimals', 'contract_address', 'blockchain_id'];

    public function blockchain(): BelongsTo
    {
        return $this->belongsTo(Blockchain::class);
    }
}