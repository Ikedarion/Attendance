<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'name' => 'シャンプー・ボディーソープ・タオル',
            'price' => 3000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E3%82%B7%E3%83%A3%E3%83%B3%E3%83%95%E3%82%9A%E3%83%BC%E3%83%BB%E3%83%9B%E3%82%99%E3%83%86%E3%82%99%E3%82%A3%E3%83%BC%E3%82%BD%E3%83%BC%E3%83%95%E3%82%9A%E3%83%BB%E3%82%BF%E3%82%AA%E3%83%AB.jpg'
        ]);

        Item::create([
            'name' => 'シャンプー・ボディーソープ',
            'price' => 2000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E3%82%B7%E3%83%A3%E3%83%B3%E3%83%95%E3%82%9A%E3%83%BC%E3%83%BB%E3%83%9B%E3%82%99%E3%83%86%E3%82%99%E3%82%A3%E3%82%BD%E3%83%BC%E3%83%95%E3%82%9A.jpg'
        ]);

        Item::create([
            'name' => 'シャンプー・リンス・制汗スプレー・美容液・乳液・コットン',
            'price' => 6000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E3%82%B7%E3%83%A3%E3%83%B3%E3%83%95%E3%82%9A%E3%83%BC%E3%83%BB%E3%83%AA%E3%83%B3%E3%82%B9%E3%83%BB%E5%88%B6%E6%B1%97%E3%82%B9%E3%83%95%E3%82%9A%E3%83%AC%E3%83%BC%E3%83%BB%E7%BE%8E%E5%AE%B9%E6%B6%B2%E3%83%BB%E4%B9%B3%E6%B6%B2%E3%83%BB%E3%82%B3%E3%83%83%E3%83%88%E3%83%B3.jpg'
        ]);

        Item::create([
            'name' => '化粧水・美容液・制汗スプレ・コットン',
            'price' => 4000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%8C%96%E7%B2%A7%E6%B0%B4%E3%83%BB%E7%BE%8E%E5%AE%B9%E6%B6%B2%E3%83%BB%E5%88%B6%E6%B1%97%E3%82%B9%E3%83%95%E3%82%9A%E3%83%AC%E3%83%BB%E3%82%B3%E3%83%83%E3%83%88%E3%83%B3.jpg'
        ]);

        Item::create([
            'name' => '化粧水・美容液・制汗スプレー・メンボー',
            'price' => 4000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%8C%96%E7%B2%A7%E6%B0%B4%E3%83%BB%E7%BE%8E%E5%AE%B9%E6%B6%B2%E3%83%BB%E5%88%B6%E6%B1%97%E3%82%B9%E3%83%95%E3%82%9A%E3%83%AC%E3%83%BC%E3%83%BB%E3%83%A1%E3%83%B3%E3%83%9B%E3%82%99%E3%83%BC.jpg'
        ]);

        Item::create([
            'name' => '制汗スプレ×2・化粧水・美容液・コットン',
            'price' => 5000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%88%B6%E6%B1%97%E3%82%B9%E3%83%95%E3%82%9A%E3%83%AC%C3%972%E3%83%BB%E5%8C%96%E7%B2%A7%E6%B0%B4%E3%83%BB%E7%BE%8E%E5%AE%B9%E6%B6%B2%E3%83%BB%E3%82%B3%E3%83%83%E3%83%88%E3%83%B3.jpg'
        ]);

        Item::create([
            'name' => '乳液・化粧水・コットン',
            'price' => 3000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E4%B9%B3%E6%B6%B2%E3%83%BB%E5%8C%96%E7%B2%A7%E6%B0%B4%E3%83%BB%E3%82%B3%E3%83%83%E3%83%88%E3%83%B3.jpg'
        ]);

        Item::create([
            'name' => '乳液・化粧水・美容液・コットン',
            'price' => 4000,
            'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E4%B9%B3%E6%B6%B2%E3%83%BB%E5%8C%96%E7%B2%A7%E6%B0%B4%E3%83%BB%E7%BE%8E%E5%AE%B9%E6%B6%B2%E3%83%BB%E3%82%B3%E3%83%83%E3%83%88%E3%83%B3.jpg'
        ]);
    }
}
