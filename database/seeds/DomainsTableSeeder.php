<?php

use Illuminate\Database\Seeder;
use App\Domain;

class DomainsTableSeeder extends Seeder
{
    public function run()
    {
        Domain::create([
            'name' => env('DEFAULT_SHORT_DOMAIN'),
            'verified_at' => now()
        ]);

        Domain::create([
            'name' => env('PROJECT_DOMAIN'),
            'verified_at' => now()
        ]);
    }
}