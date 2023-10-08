@extends('layouts.auth.login')
@section('content')
<div class="card p-5">
<form action="{{route('login')}}" method="POST">
  @csrf
  @error('error')
  <div class="alert alert-danger" role="alert">
    There was something wrong.
  </div>
@enderror
    <!-- Email input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="email">Email address</label>
      <input type="email" id="email" class="form-control" required name="email"/>
      @error('email')
      <small class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
  
    <!-- Password input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="password">Password</label>
      <input type="password" id="password" class="form-control" required name="password"/>
      @error('password')
      <small class="form-text text-danger">{{$message}}</small>
    @enderror
    </div>
    <!-- Submit button -->
    <button type="submit" class="btn btn-primary btn-block mb-4 w-100">Sign in</button>
  </form>

</div>
@endsection
