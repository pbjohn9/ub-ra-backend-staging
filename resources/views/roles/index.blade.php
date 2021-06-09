@extends('layouts.app',[
    'title'=>'Roles'
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
                            {{ __('Roles') }}
                        </h1>

                        @can('role_create')
                            <a href="{{ route('roles.create') }}" class="btn btn-primary waves-effect waves-light pull-right">
                                {{ __('Create Role') }}
                            </a>
                        @endcan


                        <table id="roles_datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>&nbsp;</th>
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

        $('#roles_datatable').DataTable({
            "processing": true,
            "ordering":false,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('roles.index') }}",
                "type": "get"
            },
            columnDefs: [
                {"width":"100px","targets":1}
            ],
            columns:[
                {data:"title"},
                {data:"action",className:"text-center"},
            ],
        });

    });
</script>
@endsection