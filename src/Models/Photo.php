<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public $table = "photos";

    protected $fillable = ['title', 'img_url', 'filename', 'order', 'thumb_url'];

    public function photoable()
    {
      return $this->morphTo();
    }
}
