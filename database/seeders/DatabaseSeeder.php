<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name'              => 'Fajar Siagian',
            'email'             => 'fajar@mail.com',
            'password'          => \Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token'   => \Str::random(10)
        ]);
    }
}
