@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>CRUD</h3>
                    <ul>
                        <li>
                        <a href="{{route('users.index')}}"> Users</a>
                        </li>
                        <li>
                            <a href="{{route('cars.index')}}"> Cars</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
