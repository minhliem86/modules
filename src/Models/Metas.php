<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
    public $table = 'metables';

    protected $guarded = ['id'];

    public function metables()
    {
        return $this->morphTo();
    }
}
