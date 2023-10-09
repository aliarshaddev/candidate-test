<?php
namespace App\Client;

use Illuminate\Support\Facades\Http;
class ApiClient
{
    protected $contentType;
    protected $authorization;

    public function __construct()
    {
        $this->contentType = 'application/json';
    }
    public function getApiToken($email, $password)
    {
       return Http::withHeaders([
            'Content-Type' =>  $this->contentType,
            'Authorization' => 'Bearer '.config('api.auth_token'),
        ])->post(config('api.base_url').'/token', [
            'email' => $email,
            'password' => $password,
        ]);
       
    }
    public function refreshToken($accessTokenRefreshKey)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer '.config('api.auth_token'),
        ])->get(config('api.base_url').'/token/refresh/'.$accessTokenRefreshKey);
       
    }
    public function getAuthors($request)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors?orderBy='.$request->input('orderBy', 'id').'&direction='.$request->input('sortBy', 'ASC').'&limit='.$request->input('limit', '12').'&page='.$request->input('page', 1));
       
    }
    public function getAllAuthors()
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors?orderBy=id&direction=ASC&limit=100&page=1');
       
    }
    public function getAuthor($author_id)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors/'.$author_id);
       
    }
    public function deleteAuthor($author_id)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer ' . session('access_token'),
        ])->delete(config('api.base_url') . '/authors/' . $author_id);
       
    }
    public function getBooks($author_id)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/authors/'.$author_id);
       
    }
    public function deleteBook($book_id)
    {
       return Http::withHeaders([
            'Authorization' => 'Bearer ' . session('access_token'),
        ])->delete(config('api.base_url') . '/books/' . $book_id);
       
    }
    public function addBook($request)
    {
       return Http::withHeaders([
            'Content-Type' =>  $this->contentType,
            'Authorization' => 'Bearer '.session('access_token'),
        ])->post(config('api.base_url').'/books', $request);
       
    }
    public function addAuthor($token,$request)
    {
        return Http::withHeaders([
            'Content-Type' =>  $this->contentType,
            'Authorization' => 'Bearer '.$token,
        ])->post(config('api.base_url').'/authors', $request);
    }
    public function getMyProfile()
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer '.session('access_token'),
        ])->get(config('api.base_url').'/me');
    }

}
