<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoManagmentController extends Controller
{
    public function index()
    {
        return view('Admin::pages.img-managment.index');
    }
}
