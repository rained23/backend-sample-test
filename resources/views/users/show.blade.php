@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <table class="table"> 
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>                                           
                        <tbody>                                             
                            <tr>
                                <td scope="row">Kind</td>
                                <td>{{ $user->type }}</td>
                            <tr>
                                <td>Name</td>                                
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td>Phone No</td>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td>{{ $user->email }}</td>
                            </tr>

                            <tr>
                                <td>Roles</td>
                                <td>
                                    <ul>
                                        @foreach($user->roles as $role)
                                        <li>{{$role->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td>Tags</td>
                                <td>
                                    <ul>
                                        @foreach($user->tags as $tag)
                                        <li>{{$tag->name}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                                                                                                                                                                    
                        </tbody>
                    </table>

                    <div class="col-md-6 offset-md-4">
                            
                            <a href="{{route('users.index')}}" class="btn btn-secondary">
                                    {{ __('Back') }}
                            </a>
                                
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
