<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    private function validateBookData()
    {
        $request = Request();
        return $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'format' => 'required|string|max:255',
            'pages' => 'required|integer',
        ]);
    }
    public function deleteBook($book_id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('access_token'),
        ])->delete(config('api.base_url') . '/books/' . $book_id);
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Book deleted.');
        } else {
            return redirect()->back()->with('error', 'There was an error deleting the book.');
        }      
    }
    public function showAddBookForm()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors?orderBy=id&direction=ASC&limit=100&page=1');
        if ($response->successful()) {
            $data = $response->json();
            return view('book.add', ['authors' => $data['items']]);
        } else {
            return redirect()->back()->with('error', 'There was an error.');
        }
    }
    public function addBook()
    {
        $data = $this->validateBookData();
        $request = array();
        $request['title'] = $data['title'];
        $request['release_date'] = $data['release_date'];
        $request['description'] = $data['description'];
        $request['isbn'] = $data['isbn'];
        $request['format'] = $data['format'];
        $request['number_of_pages'] = (int) $data['pages'];
        $request['author'] = array();
        $request['author']['id'] = $data['author'];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.session('access_token'),
        ])->post(config('api.base_url').'/books', $request);
        if ($response->successful()) {
            return redirect()->route('author.books', $data['author'])->with('success', 'Book Added.');
        }
        else
        {
            return redirect()->back()->with('error', 'There was an error adding book.');
        }
    }
}
