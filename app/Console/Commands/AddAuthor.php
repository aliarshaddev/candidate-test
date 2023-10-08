<?php

namespace App\Console\Commands;
use Session;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
class AddAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add author by command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        echo "Enter credentials First.";
        $email = $this->ask('Email');
        $password = $this->secret('Password');
        $request = array();
        $request['first_name'] = $this->ask('First Name');
        $request['last_name'] = $this->ask('Last Name');
        $request['birthday'] = Carbon::parse($this->ask('Birthday (2023-12-13)'))->format('Y-m-d');
        $request['biography'] = $this->ask('Biography');
        $request['gender'] = $this->ask('Gender (male/female)');
        $request['place_of_birth'] = $this->ask('Place of birth');
        // Make an API request to log in the user
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('api.auth_token'),
        ])->post(config('api.base_url').'/token', [
            'email' => $email,
            'password' => $password,
        ]);
        if ($response->successful()) {
            $data = $response->json();
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$data['token_key'],
            ])->post(config('api.base_url').'/authors', $request);
            if ($response->successful()) {
                echo "Author added.";
            }
            else
            {
                echo "There was an problem adding author.";
            }
        }
        else
        {
            echo "There was an problem generating token.";
        }
    }
}
