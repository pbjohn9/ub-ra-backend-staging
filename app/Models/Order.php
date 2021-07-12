<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Order extends Model
{
    use HasFactory;

    public static function getBundleTotal($currentBundle)
    {
    	$objBundle = $currentBundle;

    	$bundle_total = 0;
    	if(!empty($objBundle->id)) {
    		$start_date = Carbon::parse($objBundle->start_date);
    		$end_date = Carbon::parse($objBundle->end_date);
    		$bundle_id = $objBundle->bundle_id;

    		$bundle_total = Order::whereHas("product",function($q) use ($bundle_id){
    			$q->where('bundle_id', $bundle_id);
    		})
    		->where('trans_date',">=", $start_date->toDateTimeString())
    		->where('trans_date',">=", $end_date->toDateTimeString())
    		->sum('paid');
    	}
    	return $bundle_total;
    }

    public function product()
    {
    	return $this->belongsTo(Product::class,"product_id","product_id");
    }

    public static function recentTransId()
    {
    	$today = date("Y-m-d H:i:s");
        $first_mo = date("Y-m-01");

        $mtd_sales = Order::whereBetween('trans_date', [$first_mo, $today])
        	->sum('paid');
        return $mtd_sales;
    }

    public static function mtdPercent($mtd_sales)
    {
    	return number_format(($mtd_sales/200000)*100,2)."%";
    }

    public static function mtdOrders()
    {
    	$today = date("Y-m-d H:i:s");
        $first_mo = date("Y-m-01");

        $mtd_orders = Order::whereBetween('trans_date', [$first_mo, $today])
        	->count();
        return $mtd_orders;
    }

    public static function mtdLastMonthOrders()
    {
    	$last_mo = date("Y-m", strtotime("-1 months"));
    	$last_mo_start =date('Y-m-01', strtotime($last_mo));
		$last_mo_end = date('Y-m-t', strtotime($last_mo));

		$mtd_last_month_order = Order::whereBetween('trans_date', [$last_mo_start, $last_mo_end])
        	->count();
        return $mtd_last_month_order;
    }

    public static function mtdOrderPercent($mtd_orders, $mtd_last_month_order)
    {
    	$mtd_order_percent = !empty($mtd_last_month_order) ? ($mtd_orders/$mtd_last_month_order)*100 : 0;
    	return number_format($mtd_order_percent,2)."%";
    }

    public static function getDateWiseTableDataByBundle($objBundle)
    {

        $ordersQuery = Order::select([
            DB::raw("count(paid) as order_count"),
            DB::raw("sum(paid) as order_paid"),
            DB::raw("date_format(trans_date,'%Y-%m-%d') as t_date")
        ])->whereHas("product",function($q) use ($objBundle){
            $q->where('bundle_id',$objBundle->bundle_id);
            $q->whereNotIn('type',['cheat sheets', 'upsell', 'special offer']);
        })
        ->where('trans_date',">=", $objBundle->start_date)
        ->where('trans_date',"<=", $objBundle->end_date)
        ->groupBy(DB::raw("date_format(trans_date,'%Y-%m-%d')"))->get();

        $orders_arr = $ordersQuery->keyBy('t_date');

        $dailyTotalQuery = Order::select([
            DB::raw("count(paid) as daily_count"),
            DB::raw("sum(paid) as daily_paid"),
            DB::raw("date_format(trans_date,'%Y-%m-%d') as t_date")
        ])->whereHas("product",function($q) use ($objBundle){
            $q->where('bundle_id',$objBundle->bundle_id);
        })
        ->where('trans_date',">=", $objBundle->start_date)
        ->where('trans_date',"<=", $objBundle->end_date)
        ->groupBy(DB::raw("date_format(trans_date,'%Y-%m-%d')"))->get();

        $daily_total_arr = $dailyTotalQuery->keyBy('t_date');

        $cheatQuery = Order::select([
            DB::raw("count(paid) as cheat_count"),
            DB::raw("sum(paid) as cheat_paid"),
            DB::raw("date_format(trans_date,'%Y-%m-%d') as t_date")
        ])->whereHas("product",function($q) use ($objBundle){
            $q->where('bundle_id',$objBundle->bundle_id);
            $q->where('type','Cheat Sheets');
        })
        ->where('trans_date',">=", $objBundle->start_date)
        ->where('trans_date',"<=", $objBundle->end_date)
        ->groupBy(DB::raw("date_format(trans_date,'%Y-%m-%d')"))->get();

        $cheat_arr = $cheatQuery->keyBy('t_date');

        $upsellQuery = Order::select([
            DB::raw("count(paid) as upsell_count"),
            DB::raw("sum(paid) as upsell_paid"),
            DB::raw("date_format(trans_date,'%Y-%m-%d') as t_date")
        ])->whereHas("product",function($q) use ($objBundle){
            $q->where('bundle_id',$objBundle->bundle_id);
            $q->where('type','Upsell');
        })
        ->where('trans_date',">=", $objBundle->start_date)
        ->where('trans_date',"<=", $objBundle->end_date)
        ->groupBy(DB::raw("date_format(trans_date,'%Y-%m-%d')"))->get();

        $upsell_arr = $upsellQuery->keyBy('t_date');

        // printarrq($cheat_arr);
        
        // $pageviews= get_pageviews($day,$day,$current_bundle['bundle_id']);

        
        // $sales_chart_data["Date"] = $day;
        // $sales_chart_data["Sales Page Views"] = $pageviews;
        // $sales_chart_data["Orders"] = $data["Count(paid)"];
        // $sales_chart_data["Revenue"] = $formatter->formatCurrency($daily_tot["SUM(paid)"], 'USD');
        // $sales_chart_data["Bumps"] = $cheats["COUNT(paid)"];
        // $sales_chart_data["Bump_p"] = !empty($data["Count(paid)"]) ? number_format(($cheats["COUNT(paid)"]/$data["Count(paid)"])*100, 2)."%":0;
        // $sales_chart_data["Upsells"] = $upsell["COUNT(paid)"];
        // $sales_chart_data["Upsell_p"] = !empty($data['Count(paid)']) ? number_format(($upsell["COUNT(paid)"]/$data["Count(paid)"])*100, 2)."%":0 ;
        // $sales_chart_data["Conv_p"] = !empty($data["Count(paid)"]) ? round(($data["Count(paid)"]/$pageviews)*100, 2) ."%":0;
        // $sales_chart_data["EPC"] = !empty($pageviews) ? $formatter->formatCurrency($daily_tot["SUM(paid)"]/$pageviews, 'USD'):0;
        // $sales_chart_data["Cart"] = !empty($daily_tot["Count(paid)"]) ? $formatter->formatCurrency($daily_tot["SUM(paid)"]/$data["Count(paid)"],'USD'):0;

    }
}
