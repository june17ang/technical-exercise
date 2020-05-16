<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name'  => 'admin',
            'email' => 'admin@test.com',
            'password' => '$2y$12$RGdNcnI/EF7Pi1ZqY.b4F.3XxC8VseOyHXauA17giGveByD9DhN5K',
        ]);
    }
}
