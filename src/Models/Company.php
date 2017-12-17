<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $table = "companies";

    protected $fillable = ['email','address', 'phone', 'map'];
}
