@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cars
                    <div class="float-right">
                        <a href="{{ route('cars.create') }}" class="btn btn-success"><span class="oi oi-plus"></span></a>
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
                                <th scope="col">Registration No.</th>
                                <th scope="col">Build</th>
                                <th scope="col">Model</th>
                                <th scope="col">Year</th>
                                <th scope="col">Featured</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                     
                        @foreach($cars as $car)
                            <tr>                                                               
                                <td>{{$car->registration_no}}</td>
                                <td>{{$car->build}}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->year }}</td>
                                <td>
                                    @if($car->is_featured)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td> 
                                    
                                    <form method="POST" action="{{route('cars.destroy',$car->id)}}">
                                        @csrf 
                                        @method('delete')
                                            <a class="btn btn-outline-primary" href="{{ route('cars.show',$car->id) }}">
                                                <span class="oi oi-eye"></span>
                                            </a>
                                            <a class="btn btn-outline-primary" href="{{ route('cars.edit',$car->id) }}">
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
                                
                                <form method="GET" action="{{ route('cars.index') }}">                                
                
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
                                                    <a href="{{route('cars.index')}}" class="btn btn-secondary">Clear</a>
                                                </div>
                                            </div>
                                </form>
                    
                                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row justify-content-center mt-2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    Filter
                                </div>
                
                                <div class="card-body">
                                    
                                    <form method="GET" action="{{ route('cars.index') }}">                                
                                                    
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
                                                <a href="{{route('cars.index')}}" class="btn btn-secondary">Clear</a>
                                            </div>
                                        </div>

                                    </form>                                                                            
                                    
                                </div>
                            </div>
                        </div>
                    </div>
    
            </div>
    </div>
</div>
@endsection
