@extends('layouts.app',[
    'title'=>'Users'
])

@section('css')
<!-- DataTables -->
<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
 <!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h1 class="mt-0 header-title d-inline-block">
                            {{ __('Users') }}
                        </h1>

                        @can('user_create')
                            <a href="{{ route('users.create') }}" class="btn btn-primary waves-effect waves-light pull-right">
                                {{ __('Create') }}
                            </a>
                        @endcan


                        <table id="users_datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $(function(){

        $('#users_datatable').DataTable({
            "processing": true,
            "ordering":false,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('users.index') }}",
                "type": "get"
            },
            columnDefs: [{
                width:"100px",targets:3
            }],
            columns:[
                {data:"name"},
                {data:"email"},
                {data:"role",className:"text-center"},
                {data:"action",className:"text-center"},
            ],
        });

    });
</script>
@endsection