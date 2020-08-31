<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
            ['name' => 'An Giang'],
            ['name' => 'Bà Rịa - Vũng Tàu'],
            ['name' => 'Bắc Giang'],
            ['name' => 'Bắc Kạn'],
            ['name' => 'Bạc Liêu'],
            ['name' => 'Bắc Ninh'],
            ['name' => 'Bến Tre'],
            ['name' => 'Bình Định'],
            ['name' => 'Bình Dương'],
            ['name' => 'Bình Phước'],
            ['name' => 'Bình Thuận'],
            ['name' => 'Cà Mau'],
            ['name' => 'Cao Bằng'],
            ['name' => 'Cần Thơ'],
            ['name' => 'Đà Nẵng'],
            ['name' => 'Đắk Lắk'],
            ['name' => 'Đắk Nông'],
            ['name' => 'Điện Biên'],
            ['name' => 'Đồng Nai'],
            ['name' => 'Đồng Tháp'],
            ['name' => 'Gia Lai'],
            ['name' => 'Hà Giang'],
            ['name' => 'Hà Nam'],
            ['name' => 'Hà Nội'],
            ['name' => 'Hà Tĩnh'],
            ['name' => 'Hải Dương'],
            ['name' => 'Hải Phòng'],
            ['name' => 'Hậu Giang'],
            ['name' => 'Hòa Bình'],
            ['name' => 'Hưng Yên'],
            ['name' => 'Hồ Chí Minh'],
            ['name' => 'Khánh Hòa'],
            ['name' => 'Kiên Giang'],
            ['name' => 'Kon Tum'],
            ['name' => 'Lai Châug'],
            ['name' => 'Lâm Đồng'],
            ['name' => 'Lạng Sơn'],
            ['name' => 'Lào Cai'],
            ['name' => 'Long An'],
            ['name' => 'Nam Định'],
            ['name' => 'Nghệ An'],
            ['name' => 'Ninh Bình'],
            ['name' => 'Ninh Thuận'],
            ['name' => 'Phú Thọ'],
            ['name' => 'Phú Yên'],
            ['name' => 'Quảng Bình'],
            ['name' => 'Quảng Nam'],
            ['name' => 'Quảng Ngãi'],
            ['name' => 'Quảng Ninh'],
            ['name' => 'Quảng Trị'],
            ['name' => 'Sóc Trăng'],
            ['name' => 'Sơn La'],
            ['name' => 'Tây Ninh'],           
            ['name' => 'Thái Bình'],           
            ['name' => 'Thái Nguyên'],           
            ['name' => 'Thanh Hóa'],           
            ['name' => 'Thừa Thiên Huế'],
            ['name' => 'Tiền Giang'],         
            ['name' => 'Trà Vinh'],         
            ['name' => 'Tuyên Quang'],         
            ['name' => 'Vĩnh Long'],         
            ['name' => 'Vĩnh Phúc'],         
            ['name' => 'Yên Bái'],                
        ]);
    }
}
