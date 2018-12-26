<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $table = 'albums';

    protected $guarded = ['id'];

    public function photos()
    {
        return $this->morphMany('App\Models\Photo', 'photoable');
    }
}
