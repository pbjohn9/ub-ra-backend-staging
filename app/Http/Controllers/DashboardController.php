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
    	ini_set("memory_limit",-1);
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
    	$revenue_and_trend = Order::getRevenueAndTrendTotal($currentBundle, $lastBundle, $lb_bundle_total);
    	// bundle percent
    	$bundle_percent = Bundle::getPercent($bundle_total,$lb_bundle_total);

    	// google analytics service init
    	$objGService = new GoogleAnalyticsService();
    	$objGService->init();

    	// get traffic from google analytics
    	$tot_bundle_traffic = $objGService->getPageView(
    		$currentBundle->start_date, 
    		$currentBundle->end_date,
    		$currentBundle
    	);
    	$last_tot_bundle_traffic = $objGService->getPageView(
    		$lastBundle->start_date, 
    		$lastBundle->end_date,
    		$lastBundle
    	);

    	// bundle traffic percent
    	$bundle_traffic_percent = $objGService->getPercent(
    		$tot_bundle_traffic, 
    		$last_tot_bundle_traffic
    	);

    	// mtd sales
    	$mtd_sales = Order::recentTransId();
    	$mtd_percent = Order::mtdPercent($mtd_sales);

    	// mtd ordres
    	$mtd_orders = Order::mtdOrders();
		$mtd_last_month_order = Order::mtdLastMonthOrders();
		$mtd_order_percent = Order::mtdOrderPercent($mtd_orders, $mtd_last_month_order);

		// Sales Order Table
		$sales_table = Order::getDateWiseTableDataByBundle($objGService,$currentBundle);
		$lb_sales_table = Order::getDateWiseTableDataByBundle($objGService,$lastBundle);

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
    		"mtd_sales" => $mtd_sales,
    		"mtd_percent" => $mtd_percent,
    		"mtd_orders"=> $mtd_orders,
			"mtd_last_month_order"=> $mtd_last_month_order,
			"mtd_order_percent"=> $mtd_order_percent,
			"sales_table" => $sales_table,
			"lb_sales_table" => $lb_sales_table,
			"revenue_and_trend" => $revenue_and_trend,
    		"input" => $input,
    	]);
    }
}