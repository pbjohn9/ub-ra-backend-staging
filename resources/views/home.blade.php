@extends('layouts.app',[
    'title'=>'Home'
])

@section('css')
<link rel="stylesheet" href="{{ URL::asset("assets/plugins/chartist/css/chartist.css") }}">
@endsection

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
                            @php
                                $total_pageview = 0;
                                $total_order = 0;
                                $total_revenue_tot = 0;
                                $total_cheats = 0;
                                $total_cheat_per = 0;
                                $total_upsells = 0;
                                $total_upsells_per = 0;
                                $total_conversion = 0;
                                $total_epc = 0;
                                $total_cart = 0;
                            @endphp
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
                                    <td>@money($cart)</td>
                                </tr>
                                @php
                                    $total_pageview += intval($pageviews);
                                    $total_order += intval($orders);
                                    $total_revenue_tot += intval($total_revenue);
                                    $total_cheats += intval($cheats);
                                    $total_cheat_per = $cheat_per;
                                    $total_upsells += intval($upsells);
                                    $total_upsells_per = $upsell_per;
                                    $total_conversion = $conversion_p;
                                    $total_epc = $epc;
                                    $total_cart = $cart;
                                @endphp
                            @endforeach
                            <tr>
	                            <td>Totals:</td>
	                            <td>{{ $total_pageview }}</td>
	                            <td>{{ $total_order }}</td>
	                            <td>@money($total_revenue_tot)</td>
	                            <td>{{ $total_cheats }}</td>
	                            <td>@percentfmt($total_cheat_per)</td>
	                            <td>{{ $total_upsells }}</td>
	                            <td>@percentfmt($total_upsells_per)</td>
	                            <td>{{ $total_conversion }}</td>
                                <td>@money($total_epc)</td>
                                <td>@money($total_cart)</td>
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
                <h4 class="mt-0 header-title">Sales Table: {{ $lastBundle->bundle_id }}</h4>
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
                        @php
                                $total_pageview = 0;
                                $total_order = 0;
                                $total_revenue_tot = 0;
                                $total_cheats = 0;
                                $total_cheat_per = 0;
                                $total_upsells = 0;
                                $total_upsells_per = 0;
                                $total_conversion = 0;
                                $total_epc = 0;
                                $total_cart = 0;
                            @endphp
                            @foreach(getDatesInterval($lastBundle) as $date)
                                <tr>
                                    @php
                                        $day = $date->format("Y-m-d");
                                        $pageviews = $lb_sales_table["pageviews"][$day] ?? "";
                                        $orders = $lb_sales_table["orders"][$day]->order_count ?? 0;
                                        $total_revenue = $lb_sales_table["daily_total"][$day]->daily_paid ?? 0;
                                        $cheats = $lb_sales_table["cheats"][$day]->cheat_count ?? 0;
                                        $cheat_per = (
                                            !empty($lb_sales_table["orders"][$day]->order_count) && 
                                            !empty($lb_sales_table["cheats"][$day]->cheat_count)
                                        ) ? (($lb_sales_table["cheats"][$day]->cheat_count / $lb_sales_table["orders"][$day]->order_count) * 100) : 0;
                                        $upsells = $lb_sales_table['upsells'][$day]->upsell_count ?? 0;
                                        $upsell_per = (
                                            !empty($lb_sales_table["orders"][$day]->order_count) && 
                                            !empty($lb_sales_table["upsells"][$day]->upsell_count)
                                        ) ? (($lb_sales_table["upsells"][$day]->upsell_count / $lb_sales_table["orders"][$day]->order_count) * 100) : 0;
                                        $conversion_p = (
                                            !empty($lb_sales_table["orders"][$day]->order_count) && 
                                            !empty($pageviews)
                                        ) ? round(($lb_sales_table["orders"][$day]->order_count / $pageviews) * 100, 2)."%" : 0;
                                        $epc = (
                                            !empty($lb_sales_table["daily_total"][$day]->daily_paid) && 
                                            !empty($pageviews)
                                        ) ? ($lb_sales_table["daily_total"][$day]->daily_paid / $pageviews * 100) : 0;
                                        $cart = (
                                            !empty($lb_sales_table["daily_total"][$day]->daily_paid) && 
                                            !empty($lb_sales_table["orders"][$day]->order_count)
                                        ) ? (($lb_sales_table["daily_total"][$day]->daily_paid / $lb_sales_table["orders"][$day]->order_count) * 100) : 0;
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
                                    <td>@money($cart)</td>
                                </tr>
                                @php
                                    $total_pageview += intval($pageviews);
                                    $total_order += intval($orders);
                                    $total_revenue_tot += intval($total_revenue);
                                    $total_cheats += intval($cheats);
                                    $total_cheat_per = $cheat_per;
                                    $total_upsells += intval($upsells);
                                    $total_upsells_per = $upsell_per;
                                    $total_conversion = $conversion_p;
                                    $total_epc = $epc;
                                    $total_cart = $cart;
                                @endphp
                            @endforeach
                            <tr>
                                <td>Totals:</td>
                                <td>{{ $total_pageview }}</td>
                                <td>{{ $total_order }}</td>
                                <td>@money($total_revenue_tot)</td>
                                <td>{{ $total_cheats }}</td>
                                <td>@percentfmt($total_cheat_per)</td>
                                <td>{{ $total_upsells }}</td>
                                <td>@percentfmt($total_upsells_per)</td>
                                <td>{{ $total_conversion }}</td>
                                <td>@money($total_epc)</td>
                                <td>@money($total_cart)</td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Transactions -->
{{-- Row 2 --}}
<div class="row">

    <div class="col-xl-9">

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-20" >
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Sales Trend</h4>

                        <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                            <li class="list-inline-item">
                                <h5 class="mb-0" style="color:#ea553d">@money(end($revenue_and_trend["revenue_total"]))</h5>
                                <p class="text-muted font-14">{{ $currentBundle->bundle_id }}<br>Revenue</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0" style="color:#3bc3e9">@money($lb_bundle_total)</h5>
                                <p class="text-muted font-14">{{ $lastBundle->bundle_id }}<br>Revenue</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0" style="color:#5468DE">@money($currentBundle->budget)</h5>
                                <p class="text-muted font-14">{{ $currentBundle->bundle_id }}<br>Budget</p>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0" style="color:#ffbb44">@money($currentBundle->goal)</h5>
                                <p class="text-muted font-14">{{ $currentBundle->bundle_id }}<br>Target</p>
                            </li>
                        </ul>

                        <style type="text/css">
                            .ct-chart .ct-series.ct-series-e .ct-line {
                                stroke: #ea553d;
                                stroke-width: 2px;
                                stroke-dasharray: 5px 2px;
                            }

                        </style>

                        <div id="sales-line-chart" class="ct-chart ct-golden-section"></div>

                      <!-- check footer for code -->

                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-xl-3">
        <div class="card m-b-20">
            <div class="card-body">
                <h4 class="mt-0 header-title">Sales Spread</h4>

                <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                    <li class="list-inline-item">
                        <h7 class="mb-0" style="color:#5468da">@money($bundle_total)</h7>
                        <p class="text-muted font-14">Total Sales</p>
                    </li>
                    <li class="list-inline-item">
                        <h7 class="mb-0" style="color:#ffbb44"><?PHP //echo $formatter->formatCurrency($tot_aff['sales'], 'USD'); ?></h7>
                        <p class="text-muted font-14">Aff Sales</p>
                    </li>
                </ul>

                <div id="sales-pie" class="morris-charts" style="height: 300px"></div>

                <ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
                    <li class="list-inline-item">
                        <h7 class="mb-0" style="color:#5468da"><?PHP //echo $sales_chart_total['conv_p']; ?></h7>
                        <p class="text-muted font-14">Total Conv. %</p>
                    </li>
                    <li class="list-inline-item">
                        <h7 class="mb-0" style="color:#ffbb44"><?PHP //echo !empty($tot_aff['sale_count'])?round(($tot_aff['sale_count']/$tot_aff['clicks'])*100, 2)."%":0; ?></h7>
                        <p class="text-muted font-14">Aff Conv. %</p>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!--Chartist Chart-->
<script src="{{ URL::asset('assets/plugins/chartist/js/chartist.min.js') }}"></script>
<script type="text/javascript">
    new Chartist.Line('#sales-line-chart', {
      labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5','Day 6','Day 7','Day 8','Day 9','Day 10','Day 11','Day 12','Day 13','Day 14'],
      
      series: [
        
        {!! json_encode($revenue_and_trend['budget_total']) !!},
        {!! json_encode($revenue_and_trend['goal_total']) !!},
        {!! json_encode($revenue_and_trend['lb_revenue_total']) !!},
        {!! json_encode($revenue_and_trend['revenue_total']) !!},
        {!! json_encode($revenue_and_trend['revenue_trend']) !!},
  
      ]
    }, {
      fullWidth: true,
      chartPadding: {
        right: 40
      },
      
    });
</script>
<!-- Required datatable js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Datatable init js -->
<script type="text/javascript" src="{{ URL::asset('assets/pages/datatables.init.js') }}"></script>
<!-- Peity chart JS -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/peity-chart/jquery.peity.min.js') }}"></script>
<!--C3 Chart-->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/d3/d3.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/plugins/c3/c3.min.js') }}"></script>
<!-- Page specific js -->
<script type="text/javascript" src="{{ URL::asset('assets/pages/dashboard.js') }}"></script>
@endsection
