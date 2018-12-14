<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';

    protected $guarded = ['id'];

    public function meta_configs()
    {
        return $this->morphMany('App\Models\Metas', 'metables');
    }
}
