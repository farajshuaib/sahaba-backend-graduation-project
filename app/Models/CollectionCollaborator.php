<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionCollaborator extends Model
{
    protected $fillable = ['collection_id', 'user_id'];
}
