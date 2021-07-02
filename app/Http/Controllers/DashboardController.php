<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bundle;
use App\Models\Order;
use App\Services\GoogleAnalyticsService;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
    	// handling inputs
    	$input = $request->all();
    	$input['bundle'] = $input['bundle'] ?? "";
    	$input['vsbundle'] = $input['vsbundle'] ?? "";
    	// bundle query for listing
    	$bundles = Bundle::orderBy("start_date","desc")->get();
    	// Get First Bundle And Last Bundle
    	list($currentBundle, $lastBundle) = Bundle::getBundles($input);
    	// counts query for bundles
    	$bundle_total = Order::getBundleTotal($currentBundle);
    	$lb_bundle_total = Order::getBundleTotal($lastBundle);
    	// bundle percent
    	$bundle_percent = Bundle::getPercent($bundle_total,$lb_bundle_total);

    	// google analytics service init
    	$objGService = new GoogleAnalyticsService();
    	$objGService->init();

    	// get traffic from google analytics
    	$tot_bundle_traffic = $objGService->getPageView($currentBundle);
    	$last_tot_bundle_traffic = $objGService->getPageView($lastBundle);

    	// bundle traffic percent
    	$bundle_traffic_percent = $objGService->getPercent($tot_bundle_traffic, $last_tot_bundle_traffic); 

    	return view("home",[
    		"bundles" => $bundles,
    		"currentBundle" => $currentBundle,
    		"lastBundle" => $lastBundle,
    		"bundle_total" => $bundle_total,
    		"lb_bundle_total" => $lb_bundle_total,
    		"bundle_percent" => $bundle_percent,
    		"tot_bundle_traffic" => $tot_bundle_traffic,
    		"last_tot_bundle_traffic" => $last_tot_bundle_traffic,
    		"bundle_traffic_percent" => $bundle_traffic_percent,
    		"input" => $input,
    	]);
    }
}