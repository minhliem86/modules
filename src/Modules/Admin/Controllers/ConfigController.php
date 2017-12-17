<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ConfigRepository;

class ConfigController extends Controller
{
    protected $config;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
    }

    public function index(Request $request)
    {
        $method = $request->method();

        switch ($method){
            case 'POST' :
                $data = [
                  'title' => 'config',
                  'ga_id' => $request->get('ga_id'),
                ];
                $config = $this->config->create($data);
                return redirect()->route('admin.config');
                break;

            case 'PUT' :
                $config =  $this->config->findByField('title',$request->get('title'))->first();
                $config->ga_id = $request->get('ga_id')->with('success','Created!');
                $config->save();
                return redirect()->route('admin.config')->with('success', 'Updated!');
                break;

            default :
                $this->config->findByField('title','config')->first() ? $data = collect($this->config->findByField('title','config')->first()) : $data = collect();
                return view('Admin::pages.config.index', compact('data'));

        }
    }
}
