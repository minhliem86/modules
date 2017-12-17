<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;

class CompanyController extends Controller
{
    public function getInformation(CompanyRepository $companyRepo, Request $request)
    {
      if($request->isMethod('put')){
        $id = $companyRepo->getFirst()->id;
        $data = [
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'map' => $request->input('map'),
        ];
        $rs = $companyRepo->update($data, $id);
        if(!$rs){
            return redirect()->back()->with('error', 'Fail to save !');
        }
        return redirect()->back()->with('success', 'Saved !');
      }
      if($request->isMethod('post')){
        $data = [
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'map' => $request->input('map'),
        ];
        $rs = $companyRepo->create($data);
        if(!$rs){
            return redirect()->back()->with('error', 'Fail to save !');
        }
        return redirect()->back()->with('success', 'Saved !');
      }
      $inst = $companyRepo->getFirst();
      // dd($inst);
      return view('Admin::pages.company.index', compact('inst'));
    }
}
