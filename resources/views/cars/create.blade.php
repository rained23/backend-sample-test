@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Car') }}</div>

                <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    <form method="POST" action="{{ route('cars.store') }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Owner') }}</label>
                                
                            <div class="col-md-6">                            
                                <select id="user" name="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : ''}}" required>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach                                                               
                                </select>

                                @if ($errors->has('user_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>                                
                        </div> 

                        <div class="form-group row">
                            <label for="registrationNo" class="col-md-4 col-form-label text-md-right">{{ __('Registration No.') }}</label>

                            <div class="col-md-6">
                                <input id="registrationNo" type="text" class="form-control{{ $errors->has('registration_no') ? ' is-invalid' : '' }}" name="registration_no" value="{{ old('registration_no') }}" required autofocus>

                                @if ($errors->has('registration_no'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('registration_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="build" class="col-md-4 col-form-label text-md-right">{{ __('Build') }}</label>

                            <div class="col-md-6">
                                <input id="registrabuildtionNo" type="text" class="form-control{{ $errors->has('build') ? ' is-invalid' : '' }}" name="build" value="{{ old('build') }}" required autofocus>

                                @if ($errors->has('build'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('build') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="model" class="col-md-4 col-form-label text-md-right">{{ __('Model') }}</label>

                            <div class="col-md-6">
                                <input id="model" type="text" class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" value="{{ old('model') }}" required autofocus>

                                @if ($errors->has('model'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-4 col-form-label text-md-right">{{ __('Year') }}</label>

                            <div class="col-md-6">
                                <input id="year" type="text" class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }}" name="year" value="{{ old('year') }}" required autofocus>

                                @if ($errors->has('year'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Location') }}</label>
    
                                <div class="col-md-6">
                                    <input id="location" type="text" placeholder='{ "lat": 3.123123, "lng": 32.123213}' class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" value="{{ old('location') }}" autofocus>
    
                                    @if ($errors->has('location'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="is_featured" class="col-md-4 col-form-label text-md-right">{{ __('Featured ?') }}</label>
    
                                <div class="col-md-6">
                                    <input id="is_featured" type="checkbox" class="form-check-input{{ $errors->has('is_featured') ? ' is-invalid' : '' }}" name="is_featured" value="{{ old('is_featured') }}">
    
                                    @if ($errors->has('is_featured'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('is_featured') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                            
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                                <a href="{{route('cars.index')}}" class="btn btn-secondary">
                                        {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
