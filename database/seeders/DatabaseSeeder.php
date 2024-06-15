<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *  
     * @return void
     */
    public function run()
    {

        Category::create(['name' => "Akademik"]);
        Category::create(['name' => "Keuangan"]);
        Category::create(['name' => "Wisuda"]);

        User::create(
            [
                'username' => "ADMIN",
                'name' => "Ahmad Dity Putra S. Adam",
                'password' => Hash::make('12345678'),
                'isAdmin' => true
            ]
        );

        User::factory(10)->create();

        Post::factory(25)->create(['category_id' => 1]);

        Comment::factory(120)->create();
    }
}
