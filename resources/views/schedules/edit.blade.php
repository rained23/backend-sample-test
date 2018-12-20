@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">{{ __('Edit Car Schedule ') }}</div>

                <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    <form method="POST" action="{{ route('schedules.update',$schedule->id) }}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="carId" class="col-md-4 col-form-label text-md-right">{{ __('Car') }}</label>
                                
                            <div class="col-md-6">                            
                                <select id="carId" name="car_id" class="form-control{{ $errors->has('car_id') ? ' is-invalid' : ''}}" required>
                                    @foreach($cars as $car)
                                        <option value="{{$car->id}}" 
                                        @if($car->id == $schedule->car->id)
                                            selected="selected"
                                        @endif    
                                        >{{$car->registration_no}}</option>
                                    @endforeach                                                               
                                </select>

                                @if ($errors->has('car_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('car_id') }}</strong>
                                    </span>
                                @endif
                            </div>                                
                        </div> 

                        <div class="form-group row">                                        
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }} :</label>
                                
                            <div class="col-md-8">                                                                                                                          
                                <input  type="datetime-local" class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" value="{{ $schedule->start->format('Y-m-d\Th:m:s') }}" required autofocus>
                                @if ($errors->has('start'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start') }}</strong>
                                </span>
                                @endif
                            </div>                                
                        </div>
                            
                        <div class="form-group row">
                            <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }} :</label>
                                
                            <div class="col-md-8">                                                                                                                          
                                <input  type="datetime-local" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" name="end" value="{{ $schedule->end->format('Y-m-d\Th:m:s') }}" required autofocus>
                                @if ($errors->has('end'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('end') }}</strong>
                                </span>
                                @endif
                            </div>                                
                        </div>                    
                                            
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <a href="{{route('schedules.index')}}" class="btn btn-secondary">
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
