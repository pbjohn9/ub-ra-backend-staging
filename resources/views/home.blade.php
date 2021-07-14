@extends('layouts.app',[
    'title'=>'Home'
])

@section('breadcrumb')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->
@endsection

@section('content')
<!-- Row 1 -->
<div style="height:60px; display: block">
</div>
<div class="row">
 	<div class="col-xl-12">
 		<div class="card m-b-20">
 			<div class="card-body">
 				<form method="post" name="myform" action="">
 					@csrf
 					<ul>
 						<li class="list-inline-item">
 							<h3 class="page-title">Choose Bundle:</h3>
 						</li>
 						<li class="list-inline-item">
 						<!-- <select name="bundle" onchange='this.form.submit()'> -->
							<select name="bundle" onchange='this.form.submit()'>
								@foreach($bundles as $bundle)
								<option value="{{ $bundle->id }}" {{ $input['bundle'] == $bundle->id ? "selected" : "" }}>{{ $bundle->bundle_name."-".fullMonthYearFormat($bundle->start_date) }}</option>
								@endforeach
							</select>
						</li>
						<li class="list-inline-item">
							<h3 class="page-title">VS Bundle:</h3>
						</li>
						<li class="list-inline-item">
							<select name="vsbundle" onchange='this.form.submit()'>
								@foreach($bundles as $bundle)
								<option value="{{ $bundle->id }}" {{ $input['vsbundle'] == $bundle->id ? "selected" : "" }}>{{ $bundle->bundle_name."-".fullMonthYearFormat($bundle->start_date) }}</option>
								@endforeach
							</select>
						</li>
						<li class="list-inline-item">
							<input type="submit" value="Submit">
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-brown mr-0 float-right"><i class="mdi mdi-buffer"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-brown">@money($bundle_total)</span>
                Bundle Sales
            </div>
            <div class="clearfix"></div> 
            <p class="text-muted mb-0 m-t-20">{{ $lastBundle->bundle_id }}: @money($lb_bundle_total)
            	<span class="pull-right">
            		<i class="fa m-r-5"></i>
            		{{ $bundle_percent }}
            	</span>
        	</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-teal mr-0 float-right"><i class="mdi mdi-coffee"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-teal">{{ $tot_bundle_traffic }}</span>
                Bundle Traffic
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20"> {{ $lastBundle->bundle_id }}: {{ $last_tot_bundle_traffic }}
            	<span class="pull-right">
            		<i class="fa m-r-5"></i>
            		{{ $bundle_traffic_percent }}
                </span>
            </p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-purple mr-0 float-right"><i class="mdi mdi-basket"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-purple">@money($mtd_sales)</span>
                MTD Sales
            </div>
            <div class="clearfix"></div>
            <p class=" mb-0 m-t-20 text-muted">MTD Goal: $200,000 
            	<span class="pull-right">
            		<i class="fa  m-r-5"></i>
            		{{ $mtd_percent }}
            	</span>
            </p>
        </div>


    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-blue-grey mr-0 float-right"><i class="mdi mdi-black-mesa"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-blue-grey">{{ $mtd_orders }}</span>
                MTD Orders
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20">Last Month: {{ $mtd_last_month_order }}
                <span class="pull-right">                 
                    <i class="fa  m-r-5"></i>
                    {{ $mtd_order_percent }}
                </span>
            </p>
        </div>
    </div>
    
</div>
<!-- End Row 1 -->

<!-- sales table row -->
<div class="row">

    <div class="col-xl-6">
        <div class="card m-b-20">
            
            <div class="card-body">
                <h4 class="mt-0 header-title">Sales Table: {{ $currentBundle->bundle_id }}</h4>
                <div class="table-responsive table-striped">
                    <table class="table mb-0">
                        <thead class="thead-default">
                            <tr>
                                <th>Day</th>
                                <th>Sales Page <br> Views</th>
                                <th>Orders</th>
                                <th>Total<br>Revenue</th>
                                <th>Bumps</th>
                                <th>Bump %</th>
                                <th>Upsells</th>
                                <th>Upsell %</th>
                                <th>Conv. %</th>
                                <th>EPC</th>
                                <th>Cart $</th>
                            </tr>
                        </thead>
                            @foreach(getDatesInterval($currentBundle) as $date)
                                <tr>
                                    @php
                                        $day = $date->format("Y-m-d");
                                        $pageviews = $sales_table["pageviews"][$day] ?? "";
                                        $orders = $sales_table["orders"][$day]->order_count ?? 0;
                                        $total_revenue = $sales_table["daily_total"][$day]->daily_paid ?? 0;
                                        $cheats = $sales_table["cheats"][$day]->cheat_count ?? 0;
                                        $cheat_per = (
                                            !empty($sales_table["orders"][$day]->order_count) && 
                                            !empty($sales_table["cheats"][$day]->cheat_count)
                                        ) ? (($sales_table["cheats"][$day]->cheat_count / $sales_table["orders"][$day]->order_count) * 100) : 0;
                                        $upsells = $sales_table['upsells'][$day]->upsell_count ?? 0;
                                        $upsell_per = (
                                            !empty($sales_table["orders"][$day]->order_count) && 
                                            !empty($sales_table["upsells"][$day]->upsell_count)
                                        ) ? (($sales_table["upsells"][$day]->upsell_count / $sales_table["orders"][$day]->order_count) * 100) : 0;
                                        $conversion_p = (
                                            !empty($sales_table["orders"][$day]->order_count) && 
                                            !empty($pageviews)
                                        ) ? round(($sales_table["orders"][$day]->order_count / $pageviews) * 100, 2)."%" : 0;
                                        $epc = (
                                            !empty($sales_table["daily_total"][$day]->daily_paid) && 
                                            !empty($pageviews)
                                        ) ? ($sales_table["daily_total"][$day]->daily_paid / $pageviews * 100) : 0;
                                        $cart = (
                                            !empty($sales_table["daily_total"][$day]->daily_paid) && 
                                            !empty($sales_table["orders"][$day]->order_count)
                                        ) ? (($sales_table["daily_total"][$day]->daily_paid / $sales_table["orders"][$day]->order_count) * 100) : 0;
                                    @endphp
                                    <td>{{ $day }}</td>
                                    <td>{{ $pageviews }}</td>
                                    <td>{{ $orders }}</td>
                                    <td>@money($total_revenue)</td>
                                    <td>{{ $cheats }}</td>
                                    <td>@percentfmt($cheat_per)</td>
                                    <td>{{ $upsells }}</td>
                                    <td>@percentfmt($upsell_per)</td>
                                    <td>{{ $conversion_p }}</td>
                                    <td>@money($epc)</td>
                                    <td>@money($epc)</td>
                                </tr>
                                @php
                                @endphp
                            @endforeach
                            <tr>
	                            <td>Totals:</td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Transactions -->
    <div class="col-xl-6">
        <div class="card m-b-20">
            <div class="card-body">
                <h4 class="mt-0 header-title">Sales Table:</h4>
                <div class="table-responsive table-striped">
                	<table class="table mb-0">
                        <thead class="thead-default">
                        <tr>
                            <th>Day</th>
                            <th>Sales Page <br> Views</th>
                            <th>Orders</th>
                            <th>Total<br>Revenue</th>
                            <th>Bumps</th>
                            <th>Bump %</th>
                            <th>Upsells</th>
                            <th>Upsell %</th>
                            <th>Conv. %</th>
                            <th>EPC</th>
                            <th>Cart $</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
	                            <td>Totals:</td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                        </tr>
                    	</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Transactions -->
@endsection
