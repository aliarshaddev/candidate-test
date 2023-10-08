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
        <h1>Add Book</h1>
        <form action="{{route('add.book')}}"  method="POST">
            @csrf
            <div class="row">
              <div class="col">
                <label class="form-label" for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Title" value="{{old('title')}}">
                @error('title')
                <small class="form-text text-danger">{{$message}}</small>
              @enderror
              </div>
              <div class="col">
                <label class="form-label" for="release_date">Release Date</label>
                <input type="date" id="release_date" name="release_date" class="form-control" placeholder="Release Date" value="{{old('release_date')}}">
                @error('release_date')
                <small class="form-text text-danger">{{$message}}</small>
              @enderror
              </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label class="form-label" for="description">Description</label>
                    <textarea type="text" id="description" name="description" class="form-control" placeholder="Description">{{old('description')}}</textarea>
                    @error('description')
                    <small class="form-text text-danger">{{$message}}</small>
                  @enderror
                  </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="form-label" for="author">Author</label>
                  <select class="form-select" id="author" aria-label="Default select example" name="author">
                    <option selected>Select Author</option>
                    @foreach ($authors as $author)
                        <option value="{{$author['id']}}" {{old('author') === $author['id'] ? 'selected' : ''}}>{{$author['first_name']}} {{$author['last_name']}}</option>
                    @endforeach
                  </select>
                  @error('author')
                  <small class="form-text text-danger">{{$message}}</small>
                @enderror
                </div>
                <div class="col">
                  <label class="form-label" for="isbn">Isbn</label>
                  <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Isbn" value="{{old('isbn')}}">
                  @error('isbn')
                  <small class="form-text text-danger">{{$message}}</small>
                @enderror
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="form-label" for="format">Format</label>
                  <input type="text" id="format" name="format" class="form-control" placeholder="Format" value="{{old('format')}}">
                  @error('format')
                  <small class="form-text text-danger">{{$message}}</small>
                @enderror
                </div>
                <div class="col">
                  <label class="form-label" for="pages">Release Date</label>
                  <input type="number" id="pages" name="pages" class="form-control" placeholder="No of pages" value="{{old('pages')}}">
                  @error('pages')
                  <small class="form-text text-danger">{{$message}}</small>
                @enderror
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block mt-4 mb-4 w-100">Save</button>
          </form>
        </div>
    </div>
</div>
@endsection
