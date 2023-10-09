<?php

namespace App\Console\Commands;

use App\Clients\ApiClient;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
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
        $apiClient = new ApiClient();
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
        $response = $apiClient->getApiToken($email, $password);
        if ($response->successful()) {
            $data = $response->json();
            $response = $apiClient->addAuthor($data['token_key'], $request);
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
