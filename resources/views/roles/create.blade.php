@extends('layouts.app',[
    'title'=>'Create - Roles'
])

@section('css')

<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mt-0 header-title d-inline-block">
                            {{ __('Create Roles') }}
                        </h1>

                        <form action="{{ route('roles.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title" placeholder="Enter title">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 form-group">
                                    <label class="control-label">{{ __('Role') }}</label>
                                    <select class="select2 form-control select2-multiple @error('permissions') is-invalid @enderror" multiple="multiple" name="permissions[]" multiple data-placeholder="Choose ...">
                                        @foreach ($permissions as $id=>$title)
                                            <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $title }}</option>
                                        @endforeach
                                    </select>
                                    @error('permissions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Save') }}</button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger waves-effect waves-light">{{ ('Cancel') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>

<script type="text/javascript">
    $(function(){
        $(".select2").select2();
    })
</script>
    
@endsection