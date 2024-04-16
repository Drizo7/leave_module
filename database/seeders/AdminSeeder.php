<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'adrian',
            'email' => 'adriankadyalunda@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password321') 
        ])->assignRole('super-admin');
    }
}
