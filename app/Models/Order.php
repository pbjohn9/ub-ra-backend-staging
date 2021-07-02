<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
}
