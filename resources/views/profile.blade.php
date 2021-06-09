@extends('layouts.app',[
    'title'=>'Profile'
])

@section('content')

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mt-0 header-title d-inline-block">
                            {{ __('Profile') }}
                        </h1>

                        <form action="{{ route('profile.update',$user->id) }}" method="post">
                            {{ csrf_field() }}
                            @method('patch')

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$user->name) }}" name="name" placeholder="Enter name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$user->email) }}" name="email" placeholder="Enter email">
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

                                <div class="col-12">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">{{ __('Update') }}</button>
                                    <a href="{{ route('home') }}" class="btn btn-danger waves-effect waves-light">{{ ('Cancel') }}</a>
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