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
        <h1>Authors</h1>
        <select id="sort-by-select" class="form-select" style="float: right;width:200px;margin-bottom: 10px">
            <option value="">Sort</option>
            <option value="ASC">Sort by ASC</option>
            <option value="DESC">Sort by DESC</option>
        </select>
        <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Place of birthday</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($authors['items'] as $index => $author)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><a href="{{route('author.books',$author['id'])}}">{{ $author['first_name'] }} {{ $author['last_name'] }}</a></td>
                    <td>{{ Carbon\Carbon::parse($author['birthday'])->isoFormat('MMMM D, YYYY') }}</td>
                    <td>{{ $author['gender'] }}</td>
                    <td>{{ $author['place_of_birth'] }}</td>
                    <td><a href='{{route('author.delete', $author['id'])}}' class="btn btn-danger">Delete</button></td>
                </tr>
            @endforeach
            </tbody>
          </table>
    
        <div class="pagination"  style="float: right">
            <select id="limit-select" class="form-select" style="margin-right: 10px">
                <option value="">No of results</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                
            </select>
            @if ($authors['current_page'] > 1)
                <a class="btn btn-primary" href="{{ url('/?page=' . ($authors['current_page'] - 1)) }}">Previous</a>
            @endif
        
            @if ($authors['current_page'] < $authors['total_pages'])
                <a class="btn btn-primary" href="{{ url('/?page=' . ($authors['current_page'] + 1)) }}">Next</a>
            @endif
        </div>
        
    </div>
</div>
<script>
    // JavaScript to add query parameters to URLs
    function addQueryParam(url, param, value) {
        const urlObject = new URL(url);
        urlObject.searchParams.set(param, value);
        return urlObject.toString();
    }

    // Function to handle dropdown selection change and navigate to the updated URL
    function handleDropdownChange(sortBySelect) {
        let attr;
        if(sortBySelect.id == 'sort-by-select')
        {
            attr = 'sortBy';
        }
        else if(sortBySelect.id == 'limit-select')
        {
            attr = 'limit';
        }
        const selectedValue = sortBySelect.value;
        const currentUrl = window.location.href;
        const updatedUrl = addQueryParam(currentUrl, attr, selectedValue);
        window.location.href = updatedUrl;
    }

    // Attach an event listener to the dropdown select element
    const selectElements = document.querySelectorAll('select');
    selectElements.forEach((selectElement) => {
        selectElement.addEventListener('change', function () {
            handleDropdownChange(selectElement);
        });
    });
</script>
@endsection
