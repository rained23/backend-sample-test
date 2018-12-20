@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Car Schedule</div>

                <div class="card-body">
                        <div class="form-group row">
                            <label for="cR" class="col-md-4 col-form-label text-md-right">{{ __('Car') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                          
                                    {{$schedule->car->registration_no}}
                                
                            </label>                                
                        </div> 

                        <div class="form-group row">
                            <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                            
                                    {{$schedule->start}}
                                
                            </label>                                
                        </div> 
                        <div class="form-group row">
                            <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                            
                                    {{$schedule->end}}
                                
                            </label>                                
                        </div> 

                        
                    <div class="col-md-6 offset-md-4">                            
                        <a href="{{route('schedules.index')}}" class="btn btn-secondary">
                                {{ __('Back') }}
                        </a>                            
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
