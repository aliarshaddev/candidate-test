@extends('layouts.app')
@section('content')
<div class="p-5">
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{session('success')}}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Profile Details</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Email:</strong> {{ $profile['email'] }}</li>
                            <li class="list-group-item"><strong>First Name:</strong> {{ $profile['first_name'] }}</li>
                            <li class="list-group-item"><strong>Last Name:</strong> {{ $profile['last_name'] }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Gender:</strong> {{ $profile['gender']}}</li>
                            <li class="list-group-item"><strong>Active:</strong> {{ $profile['active'] ? 'Yes' : 'No' }}</li>
                            <li class="list-group-item"><strong>Email Confirmed:</strong> {{ $profile['email_confirmed'] ? 'Yes' : 'No' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
            
        </div>
    </div>
</div>
@endsection
