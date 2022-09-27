<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionCollaborator extends Model
{
    use SoftDeletes;

    protected $fillable = ['collection_id', 'user_id'];
}
