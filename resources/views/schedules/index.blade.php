@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Car Schedules
                    <div class="float-right">
                        <a href="{{ route('schedules.create') }}" class="btn btn-success"><span class="oi oi-plus"></span></a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>                                
                                <th scope="col">Car</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>    
                                <th scrope="col">Action</th>                            
                            </tr>
                        </thead>
                        
                        <tbody>
                     
                        @foreach($schedules as $schedule)
                            <tr>                                                               
                                <td><a href="{{ route('cars.show',$schedule->car->id)}}">{{$schedule->car->registration_no}}</a></td>
                                <td>{{$schedule->start}}</td>
                                <td>{{ $schedule->end }}</td>                                                                
                                <td> 
                                    
                                    <form method="POST" action="{{route('schedules.destroy',$schedule->id)}}">
                                        @csrf 
                                        @method('delete')
                                            <a class="btn btn-outline-primary" href="{{ route('schedules.show',$schedule->id) }}">
                                                <span class="oi oi-eye"></span>
                                            </a>
                                            <a class="btn btn-outline-primary" href="{{ route('schedules.edit',$schedule->id) }}">
                                                <span class="oi oi-pencil"></span>
                                            </a>
                                        <button type="submit" class="btn btn-outline-danger"><span class="oi oi-trash"></span></button>
                                    </form>
                                </td>
                            </tr>                                                              
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Search
                            </div>
            
                            <div class="card-body">
                                
                                <form method="GET" action="{{ route('schedules.index') }}">                                
                
                                        <div class="form-group row">                                        
                                            <div class="col-md-12">
                                                <input id="name" type="text" class="form-control{{ $errors->has('search') ? ' is-invalid' : '' }}" name="search" value="{{ request()->input('search') }}" autofocus>                                          
                                            </div>
                                        </div>
    
                                        <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Find') }}
                                                    </button>
                                                    <a href="{{route('schedules.index')}}" class="btn btn-secondary">Clear</a>
                                                </div>
                                            </div>
                                </form>
                    
                                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
    
                {{--  <div class="row justify-content-center mt-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Filter
                            </div>
            
                            <div class="card-body">
                                
                                <form method="GET" action="{{ route('schedules.index') }}">                                
                                                
                                    <div class="form-group row">
                                        <label for="featuredFilter" class="col-md-4 col-form-label text-md-right">{{ __('Featured') }}</label>                
                                        
                                        <div class="col-md-6">                            
                                            <select id="isFeatured" name="is_featured" class="form-control">
                                                <option value="">All</option>
                                                <option value="1"
                                                @if(request()->input('is_featured') == "1")
                                                    selected="selected"
                                                @endif
                                                >Yes</option>
                                                <option value="0"
                                                @if(request()->input('is_featured') == "0")
                                                    selected="selected"
                                                @endif
                                                >No</option>
                                            </select>                                               
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Filter') }}
                                            </button>
                                            <a href="{{route('schedules.index')}}" class="btn btn-secondary">Clear</a>
                                        </div>
                                    </div>

                                </form>                                                                            
                                
                            </div>
                        </div>
                    </div>
                </div>  --}}
    
            </div>
    </div>
</div>
@endsection
