<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class AuthorController extends Controller
{
    public function index(Request  $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors?orderBy='.$request->input('orderBy', 'id').'&direction='.$request->input('sortBy', 'ASC').'&limit='.$request->input('limit', '12').'&page='.$request->input('page', 1));
        if ($response->successful()) {
            $data = $response->json();
            return view('author.index', ['authors' => $data]);
        } else {
           abort(404);
        }
    }
    public function deleteAuthor($author_id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors/'.$author_id);
        if ($response->successful()) {
            $data = $response->json();
            if(!isset($data['books']) || empty($data['books']))
            {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . session('access_token'),
                ])->delete(config('api.base_url') . '/authors/' . $author_id);
                if ($response->successful()) {
                    return redirect()->route('dashboard')->with('success', 'Author deleted.');
                } else {
                    return redirect()->route('dashboard')->with('error', 'There was an error deleting the author.');
                }                 
            }
            else
            {
                return redirect()->route('dashboard')->with('error', 'Could not delete author with books.');
            }
        } else {
            return redirect()->route('dashboard')->with('error', 'There was an error deleting the author.');
        }
    }
    public function getBooks($author_id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors/'.$author_id);
        if ($response->successful()) {
            $data = $response->json();
            return view('author.books', ['author' => $data]);
        } else {
           abort(404);
        }
    }
}
