<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    public static function getBundles($input) 
    {
    	if (!empty($input['bundle'])) {
    		$currentBundle = Bundle::where('id', $input['bundle'])->first();
    	} else {
    		$currentBundle = Bundle::orderBy("start_date","desc")->first();
    	}

    	if (!empty($input['vsbundle'])) {
    		$lastBundle = Bundle::where('id', $input['vsbundle'])->first();
    	} else {
    		$lastBundle = Bundle::orderBy("start_date","desc")->first();
    	}

    	return [$currentBundle, $lastBundle];
    }

    public static function getPercent($bundle_total,$lb_bundle_total)
    {
    	$per = !empty($lb_bundle_total) ? ($bundle_total/$lb_bundle_total)*100 : 0;
    	return number_format($per, 2)."%";
    }
}
