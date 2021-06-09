@extends('layouts.app',[
    'title'=>'Create - Permission'
])

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mt-0 header-title d-inline-block">
                            {{ __('Create Permission') }}
                        </h1>

                        <form action="{{ route('permissions.store') }}" method="post">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="name">{{ __('Title') }}</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title" placeholder="Enter title">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Save') }}</button>
                                    <a href="{{ route('permissions.index') }}" class="btn btn-danger waves-effect waves-light">{{ ('Cancel') }}</a>
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