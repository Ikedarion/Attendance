<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create([
            'name' => '寿司',
        ]);

        Genre::create([
            'name' => '焼肉',
        ]);

        Genre::create([
            'name' => '居酒屋',
        ]);

        Genre::create([
            'name' => 'イタリアン',
        ]);

        Genre::create([
            'name' => 'ラーメン',
        ]);
    }
}
