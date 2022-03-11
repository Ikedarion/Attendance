<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([
            'name' => '東京都',
        ]);

        Area::create([
            'name' => '大阪府',
        ]);

        Area::create([
            'name' => '福岡県',
        ]);
    }
}
