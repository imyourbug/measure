<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Setting;
use App\Models\TaskType;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call([
        // ]);

        User::create([
            'email' => 'duongvankhai2022001@gmail.com',
            'password' => Hash::make(1),
            'role' => 1,
        ]);
        User::create([
            'email' => 'khachhang1@gmail.com',
            'password' => Hash::make(1),
            'role' => 2,
        ]);

        Type::insert([
            [
                'name' => 'Kiểm soát côn trùng và dịch hại',
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vệ sinh công nghiệp',
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chăm sóc và duy tu cảnh quan',
                'parent_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diệt chuột',
                'parent_id' => 1, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diệt côn trùng',
                'parent_id' => 1, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diệt mối',
                'parent_id' => 1, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tưới cây',
                'parent_id' => 2, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bón phân',
                'parent_id' => 2, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phun thuốc',
                'parent_id' => 2, 'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tẩy hóa chất',
                'parent_id' => 3, 'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Giặt',
            //     'parent_id' => 3, 'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            // [
            //     'name' => 'Thu gom rác',
            //     'parent_id' => 3, 'created_at' => now(),
            //     'updated_at' => now(),
            // ]
        ]);

        Setting::create([
            'key' => 'map',
            'value' => '/',
        ]);

        Customer::create([
            'name' =>  'Khách hàng 1',
            'user_id' => 2
        ]);
        //
        Branch::insert([
            [
                'name' => 'Chi nhánh Gia Lâm',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chi nhánh Long Biên',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chi nhánh Hoàng Mai',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
