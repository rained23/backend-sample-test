@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users
                    <div class="float-right">
                        <a href="{{ route('users.create') }}" class="btn btn-success"><span class="oi oi-plus"></span></a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                                        
                    <user-table :user-ds="{{$users}}" :tags="{{$tags}}"></user-table>
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
                            
                            <form method="GET" action="{{ route('users.index') }}">                                
            
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
                                                <a href="{{route('users.index')}}" class="btn btn-secondary">Clear</a>
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
                                
                                <form method="GET" action="{{ route('users.index') }}">                                
                
                                        <div class="form-group row">
                                            <label for="kindFilter" class="col-md-4 col-form-label text-md-right">{{ __('Kind') }}</label>
                
                                            <div class="col-md-6">                            
                                                <select id="type" name="type" class="form-control">
                                                    <option value="">All</option>
                                                    <option value="Business" 
                                                        @if(request()->input('type') == "Business")
                                                            selected
                                                        @endif
                                                    >Business</option>
                                                    <option value="Product"
                                                        @if(request()->input('type') == "Product")
                                                            selected
                                                        @endif
                                                    >Product</option>
                                                </select>                                                        
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="roleFilter" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>                
                                            
                                            <div class="col-md-6">                            
                                                <select id="role" name="roles" class="form-control">
                                                    <option value="">All</option>
                                                    @foreach($roles as $role)
                                                    <option value="{{$role->id}}" 
                                                        @if(request()->input('roles') == $role->id)
                                                            selected
                                                        @endif
                                                    >{{$role->name}}</option>
                                                    @endforeach
                                                </select>                                               
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                                <label for="tagFilter" class="col-md-4 col-form-label text-md-right">{{ __('Tag') }}</label>                
                                                
                                                <div class="col-md-6">                            
                                                    <select id="tage" name="tags" class="form-control">
                                                        <option value="">All</option>
                                                        @foreach($tags as $tag)
                                                        <option value="{{$tag->id}}" 
                                                            @if(request()->input('tags') == $tag->id)
                                                                selected
                                                            @endif
                                                        >{{$tag->name}}</option>
                                                        @endforeach
                                                    </select>                                               
                                                </div>
                                            </div>
    
                                        <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Filter') }}
                                                    </button>
                                                    <a href="{{route('users.index')}}" class="btn btn-secondary">Clear</a>
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
