@extends('layouts.app',[
    'title'=>'Home'
])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ul>
                    <li class="list-inline-item">
                    <h3 class="page-title">Choose Bundle:</h3>
                </li>
                <li class="list-inline-item">
                    <form method="post" name="myform" action="">
                        <!-- <select name="bundle" onchange='this.form.submit()'> -->
                        <select name="bundle" onchange=''>
                            
                        </select>
                </li>
                <li class="list-inline-item">
                    <h3 class="page-title">VS Bundle:</h3>
                </li>
                <li class="list-inline-item">
                    <select name="vsbundle" onchange=''>
                    </select>
                </li>
                <li class="list-inline-item">
                    <input type="submit" value="Submit">
                    </form>
                </li>
            </ul>
            </div>
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->


 <!-- Row 1 -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-brown mr-0 float-right"><i class="mdi mdi-buffer"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-brown"></span>
                Bundle Sales
            </div>
            <div class="clearfix"></div> 
            <p class="text-muted mb-0 m-t-20">
            	<span class="pull-right"><i class="fa m-r-5"></i>
            	</span>
        	</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-teal mr-0 float-right"><i class="mdi mdi-coffee"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-teal"></span>
                Bundle Traffic
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20">
            	<span class="pull-right"><i class="fa m-r-5"></i>
                </span>
            </p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-purple mr-0 float-right"><i class="mdi mdi-basket"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-purple"></span>
                MTD Sales
            </div>
            <div class="clearfix"></div>
            <p class=" mb-0 m-t-20 text-muted">MTD Goal: $200,000 <span class="pull-right"><i class="fa  m-r-5"></i></span></p>
        </div>


    </div>
    <div class="col-md-6 col-xl-3">
        <div class="mini-stat clearfix bg-white">
            <span class="mini-stat-icon bg-blue-grey mr-0 float-right"><i class="mdi mdi-black-mesa"></i></span>
            <div class="mini-stat-info">
                <span class="counter text-blue-grey"></span>
                MTD Orders
            </div>
            <div class="clearfix"></div>
            <p class="text-muted mb-0 m-t-20">Last Month: 
                <span class="pull-right">
                    
                    
                    <i class="fa  m-r-5"></i>
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
                    <h4 class="mt-0 header-title">Sales Table: </h4>
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
