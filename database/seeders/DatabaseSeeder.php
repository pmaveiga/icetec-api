<?php

namespace Database\Seeders;

use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**{
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123')
        ]);

        $technologies = ['Laravel', 'Angular', 'ReactJS', 'Javascript', 'Java'];
        foreach ($technologies as $technology) {
            Technology::create(['name' => $technology]);
        }
    }
}
