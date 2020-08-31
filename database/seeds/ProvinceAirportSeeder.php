<?php

use App\Models\Province;
use App\Models\ProvinceAirport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceAirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinceNames = DB::table('provinces')->select('id', 'name')->get()->toArray();

        DB::table('province_airports')->insert([
            [
                'name' => 'Sân bay Quốc tế Nội Bài',
                'province_id' => array_search('Hà Nội', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Tân Sơn Nhất',
                'province_id' => array_search('Hồ Chí Minh', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Đà Nẵng',
                'province_id' => array_search('Đà Nẵng', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Cần Thơ',
                'province_id' => array_search('Cần Thơ', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Cát Bi – Hải Phòng',
                'province_id' => array_search('Hải Phòng', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Cam Ranh',
                'province_id' => array_search('Khánh Hòa', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Phú Quốc',
                'province_id' => array_search('Kiên Giang', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Vinh',
                'province_id' => array_search('Nghệ An', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Quốc tế Phú Bài',
                'province_id' => array_search('Thừa Thiên Huế', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Côn Đảo',
                'province_id' => array_search('Bà Rịa - Vũng Tàu', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Nà Sản',
                'province_id' => array_search('Sơn La', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Cà Mau',
                'province_id' => array_search('Cà Mau', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Buôn Ma Thuột',
                'province_id' => array_search('Đắk Lắk', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Điện Biên Phủ',
                'province_id' => array_search('Điện Biên', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Pleiku',
                'province_id' => array_search('Gia Lai', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Rạch Giá',
                'province_id' => array_search('Kiên Giang', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Liên Khương',
                'province_id' => array_search('Lâm Đồng', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Tuy Hòa',
                'province_id' => array_search('Phú Yên', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Đồng Hới',
                'province_id' => array_search('Quảng Bình', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Chu Lai',
                'province_id' => array_search('Quảng Nam', array_column($provinceNames, 'name')) + 1,
            ],
            [
                'name' => 'Sân bay Thọ Xuân',
                'province_id' => array_search('Thanh Hóa', array_column($provinceNames, 'name')) + 1,
            ],
        ]);
    }
}
