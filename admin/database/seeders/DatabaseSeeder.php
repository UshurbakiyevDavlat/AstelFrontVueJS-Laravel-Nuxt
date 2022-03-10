<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::firstOrCreate([
        //     'email' => 'admin@admin.com',
        // ], [
        //     'name' => 'Admin',
        //     'password' => \Hash::make('adminadmin'),
        //     'is_admin' => true
        // ]);

          // $this->call(PostTableSeeder::class);
      //  $this->call(PageSeeder::class);
      $this->call(SettingsSeeder::class);
    }
}
