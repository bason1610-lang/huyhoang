<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkautoDemoSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@akauto.local'],
            [
                'name' => 'Quản trị',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        DB::transaction(function () {
            OrderItem::query()->delete();
            Order::query()->delete();
            Product::query()->delete();
            Banner::query()->delete();
            Post::query()->delete();
            Category::query()->whereNotNull('parent_id')->delete();
            Category::query()->delete();
            Branch::query()->delete();

            Branch::insert([
                [
                    'name' => 'Tiệm chăm sóc xe Huy Hoàng',
                    'address' => '270 Lê Hồng Phong, Tân Đông Hiệp, Dĩ An',
                    'phone' => '0946785631',
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

            $catScreens = Category::query()->create([
                'parent_id' => null,
                'name' => 'MÀN HÌNH Ô TÔ',
                'slug' => 'man-hinh-o-to',
                'sort_order' => 1,
            ]);
            $child = Category::query()->create([
                'parent_id' => $catScreens->id,
                'name' => 'Màn hình Zestech',
                'slug' => 'man-hinh-zestech',
                'sort_order' => 1,
            ]);

            $catCam = Category::query()->create([
                'parent_id' => null,
                'name' => 'CAMERA HÀNH TRÌNH',
                'slug' => 'camera-hanh-trinh',
                'sort_order' => 2,
            ]);

            $catFilm = Category::query()->create([
                'parent_id' => null,
                'name' => 'PHIM CÁCH NHIỆT Ô TÔ',
                'slug' => 'phim-cach-nhiet-o-to',
                'sort_order' => 3,
            ]);

            $rows = [
                [
                    'category_id' => $child->id,
                    'name' => 'Màn hình Android Zestech Z18',
                    'slug' => 'man-hinh-android-zestech-z18',
                    'price' => 5_400_000,
                    'compare_price' => null,
                    'short_description' => 'CPU UIS8581, RAM 2GB, Android 10.',
                    'description' => "Tặng kèm camera hành trình, thẻ nhớ 32GB, sim 4G.\nBảo hành chính hãng.",
                    'is_featured' => true,
                ],
                [
                    'category_id' => $catCam->id,
                    'name' => 'Camera hành trình Vietmap TS-C9P',
                    'slug' => 'camera-hanh-trinh-vietmap-ts-c9p',
                    'price' => 1_831_000,
                    'compare_price' => 1_990_000,
                    'short_description' => 'Ghi hình 2K Super HD, GPS.',
                    'description' => 'Cảm biến G-Sensor, pin siêu tụ điện.',
                    'is_featured' => true,
                ],
                [
                    'category_id' => $catCam->id,
                    'name' => 'Camera hành trình 70mai M310',
                    'slug' => 'camera-hanh-trinh-70mai-m310',
                    'price' => 1_190_000,
                    'compare_price' => null,
                    'short_description' => 'Ghi hình 2K, góc 130°.',
                    'description' => 'App 70Mai, giám sát đỗ xe 24/7.',
                    'is_featured' => false,
                ],
                [
                    'category_id' => $catFilm->id,
                    'name' => 'Phim cách nhiệt Ntech',
                    'slug' => 'phim-cach-nhiet-ntech',
                    'price' => 4_600_000,
                    'compare_price' => null,
                    'short_description' => 'VLT 72%, phù hợp xe phổ thông.',
                    'description' => 'Bảo hành 10 năm.',
                    'is_featured' => true,
                ],
            ];

            foreach ($rows as $p) {
                Product::query()->create(array_merge($p, [
                    'sku' => null,
                    'image_path' => null,
                    'is_active' => true,
                    'sort_order' => 0,
                ]));
            }

            Post::query()->create([
                'title' => '6 lưu ý khi mua camera 360 độ cho ô tô',
                'slug' => '6-luu-y-khi-mua-camera-360',
                'excerpt' => 'Tránh sai lầm thường gặp khi lắp camera 360.',
                'body' => "Camera 360 giúp quan sát toàn cảnh xung quanh xe.\n\nHãy chọn đơn vị lắp đặt uy tín và bảo hành rõ ràng.",
                'published_at' => now()->subDay(),
                'is_published' => true,
            ]);
        });
    }
}
