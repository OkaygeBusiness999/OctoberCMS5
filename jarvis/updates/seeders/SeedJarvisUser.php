<?php namespace Acme\Jarvis\Updates\Seeders;

use October\Rain\Database\Updates\Seeder;
use RainLab\User\Models\User;

class SeedJarvisUser extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'jarvis@example.com'],
            [
                'first_name' => 'Jarvis',
                'last_name' => 'AI',
                'password' => bcrypt('Secur3P@ssw0rd'),
                'username' => 'jarvis@example.com',
                'activated_at' => now(),
            ]
        );
    }
}