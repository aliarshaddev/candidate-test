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
        <h1>Books</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Release Date</th>
                <th>Description</th>
                <th>Isbn</th>
                <th>Format</th>
                <th>Number of pages</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($author['books'] as $index => $book)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $book['title'] }}</td>
                    <td>{{ Carbon\Carbon::parse($book['release_date'])->isoFormat('MMMM D, YYYY') }}</td>
                    <td>{{ $book['description'] }}</td>
                    <td>{{ $book['isbn'] }}</td>
                    <td>{{ $book['format'] }}</td>
                    <td>{{ $book['number_of_pages'] }}</td>
                    <td><a href='{{route('delete.book', $book['id'])}}' class="btn btn-danger">Delete</button></td>
                </tr>
            @endforeach
            </tbody>
          </table>
          <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Author Details</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>First Name:</strong> {{ $author['first_name'] }}</li>
                            <li class="list-group-item"><strong>Last Name:</strong> {{ $author['last_name'] }}</li>
                            <li class="list-group-item"><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($author['birthday'])->format('F j, Y') }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Gender:</strong> {{ $author['gender'] }}</li>
                            <li class="list-group-item"><strong>Place of Birth:</strong> {{ $author['place_of_birth'] }}</li>
                            <li class="list-group-item"><strong>Biography:</strong> {{ isset($author['biography']) ? $author['biography'] : '' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
            
        </div>
    </div>
</div>
@endsection
