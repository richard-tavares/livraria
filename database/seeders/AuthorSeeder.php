<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::create(['name' => 'George R.R. Martin']);
        Author::create(['name' => 'J.R.R. Tolkien']);
        Author::create(['name' => 'J.K. Rowling']);
        Author::create(['name' => 'H.P. Lovecraft']);
        Author::create(['name' => 'Stephen King']);
        Author::create(['name' => 'Suzanne Collins']);
    }
}
