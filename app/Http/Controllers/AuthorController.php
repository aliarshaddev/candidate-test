<?php

namespace App\Http\Controllers;

use App\Client\ApiClient;
use Illuminate\Http\Request;
class AuthorController extends Controller
{
    protected $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }
    public function index(Request  $request)
    {
        $response = $this->apiClient->getAuthors($request);
        if ($response->successful()) {
            $data = $response->json();
            return view('author.index', ['authors' => $data]);
        } else {
           abort(404);
        }
    }
    public function deleteAuthor($author_id)
    {
        $response = $this->apiClient->getAuthor($author_id);
        if ($response->successful()) {
            $data = $response->json();
            if(!isset($data['books']) || empty($data['books']))
            {
                $response = $this->apiClient->deleteAuthor($author_id);
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
        $response = $this->apiClient->getBooks($author_id);
        if ($response->successful()) {
            $data = $response->json();
            return view('author.books', ['author' => $data]);
        } else {
           abort(404);
        }
    }
}
