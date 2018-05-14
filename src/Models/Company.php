<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $table = "companies";

    protected $primaryKey = 'company_information';

    public $incrementing = false;


    protected $fillable = ['email','address', 'phone', 'map'];
}
