<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundle;
use App\Models\Order;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
    	// handling inputs
    	$input = $request->all();
    	$input['bundle'] = $input['bundle'] ?? "";
    	$input['vsbundle'] = $input['vsbundle'] ?? "";
    	// bundle query
    	$bundles = Bundle::orderBy("start_date","desc")->get();
    	// counts query
    	$bundle_total = Order::getBundleTotal($input);
    	return view("home",[
    		"bundles" => $bundles,
    		"bundle_total" => $bundle_total,
    		"input" => $input,
    	]);
    }
}