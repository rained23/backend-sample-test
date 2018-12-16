@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Car</div>

                <div class="card-body">
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Owner') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                          
                                    {{$car->user->name}}
                                
                            </label>                                
                        </div> 

                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Registration No.') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                            
                                    {{$car->registration_no}}
                                
                            </label>                                
                        </div> 
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Build') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                            
                                    {{$car->build}}
                                
                            </label>                                
                        </div> 

                        <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Model') }} :</label>
                                    
                                <label class="col-md-6 mt-2">  
                                                                
                                        {{$car->model}}
                                    
                                </label>                                
                            </div> 

                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Year') }} :</label>
                                    
                                <label class="col-md-6 mt-2">  
                                                                
                                        {{$car->year}}
                                    
                                </label>                                
                            </div> 
                        
                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Location') }} :</label>
                                    
                                <label class="col-md-6 mt-2">  
                                                                
                                        {{$car->location}}
                                    
                                </label>                                
                            </div> 

                            <div class="form-group row">
                                    <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Featured') }} :</label>
                                        
                                    <label class="col-md-6 mt-2">  
                                                                    
                                        @if($car->is_featured)
                                            Yes
                                        @else
                                            No
                                        @endif
                                        
                                    </label>                                
                                </div> 

                    <div class="col-md-6 offset-md-4">
                            
                            <a href="{{route('cars.index')}}" class="btn btn-secondary">
                                    {{ __('Back') }}
                            </a>
                                
                        </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Car Schedule</div>
                    <div class="card-body">
                        
                        @foreach($car->schedules as $schedule)
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }} :</label>
                                
                            <label class="col-md-6 mt-2">  
                                                            
                                    {{$schedule->start}}
                                
                            </label>                                
                        </div> 
                        <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }} :</label>
                                    
                                <label class="col-md-6 mt-2">  
                                                                
                                        {{$schedule->end}}
                                    
                                </label>                                
                            </div> 
                        <hr />
                        @endforeach
                        
                    </div>
            </div>
        </div>

    </div>
</div>
@endsection
