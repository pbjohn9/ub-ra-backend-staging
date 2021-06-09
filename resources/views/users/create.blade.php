@extends('layouts.app',[
    'title'=>'Create - Users'
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
                            {{ __('Create User') }}
                        </h1>

                        <form action="{{ route('users.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" placeholder="Enter name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" placeholder="Enter email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 form-group">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 form-group">
                                    <label class="control-label">{{ __('Role') }}</label>
                                    <select class="select2 form-control select2-multiple @error('roles') is-invalid @enderror" multiple="multiple" name="roles[]" multiple data-placeholder="Choose ...">
                                        @foreach ($roles as $role_id=>$role_name)
                                            <option value="{{ $role_id }}" {{ in_array($role_id, old('roles', [])) ? 'selected' : '' }}>{{ $role_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Save') }}</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-danger waves-effect waves-light">{{ ('Cancel') }}</a>
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