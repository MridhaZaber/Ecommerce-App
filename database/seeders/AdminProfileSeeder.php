<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        $vendor = new Vendor();
        $vendor->banner = 'uploads/1234.jpg';
        $vendor->shop_name='Admin Shop';
        $vendor->phone = '123456789';
        $vendor->email = 'admin@gmail.com';
        $vendor->address = 'Usa';
        $vendor->email = 'admin@gmail.com';
        $vendor->description = 'shop Description';
        $vendor->user_id=$user->id;
        $vendor->save();

    }
}
