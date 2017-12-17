<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use developeruz\Analytics\Period;
use developeruz\Analytics\Analytics;
use Carbon\Carbon;
//use App\Repositories\ProductRepository;
//use App\Repositories\SupportRepository;
//use App\Repositories\ContactRepository;

class DashboardController extends Controller
{
    protected $analytic;
    protected $product;
    protected $support;
    protected $contact;

//    public function __construct(Analytics $analytic, ProductRepository $product, SupportRepository $support, ContactRepository $contact)
//    {
//        $this->analytic = $analytic;
//        $this->product = $product;
//        $this->support = $support;
//        $this->contact = $contact;
//    }
//
//    public function index(Request $request)
//    {
//
//
//        if($request->ajax()){
//            if($request->has('week')){
//                 $ga = $this->analytic->fetchTotalVisitorsAndPageViews(Period::days(7));
//            }else{
//                $from = $request->input('from');
//                $to = $request->input('to');
//
//                $start_d = Carbon::createFromFormat('d-m-Y', $from);
//                $to_d = Carbon::createFromFormat('d-m-Y', $to);
//                $date = Period::create($start_d, $to_d);
//                $ga = $this->analytic->fetchTotalVisitorsAndPageViews($date);
//            }
//            return view('Admin::ajax.ajaxChart', compact('ga'))->render();
//        }else{
//            $ga = $this->analytic->fetchTotalVisitorsAndPageViews(Period::days(7));
//        }
//        $number_product =$this->product->all()->count();
//        $number_support =$this->support->all()->count();
//        $number_contact =$this->contact->all()->count();
//        return view('Admin::pages.index', compact('ga', 'number_product', 'number_support', 'number_contact'));
//    }

    public function index ()
    {
        return view('Admin::pages.dashboard.index');
    }
}
