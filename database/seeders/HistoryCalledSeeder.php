<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HistoryCalledSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // [
            //     'area_customer_id' => 1,
            //     'so_thu_tu' => '1',
            //     'vpbank' => 'bank1',
            //     'msdl' => 'msdl',
            //     'cv' => 'cv',
            //     'so_hop_dong' => '09223322',
            //     'menh_gia' => '1000000',
            //     'nam_dao_han' => '2040',
            //     'ho' => 'dang',
            //     'ten' => 'quy',
            //     'ten_kh' => 'khach hang 1',
            //     'gioi_tinh' => 'M',
            //     'ngay_sinh' => '1996',
            //     'tuoi' => '20',
            //     'comment' => 'comment',
            //     'type_call' => 2,
            //     'dien_thoai' => '097292323',
            //     'dia_chi_cu_the' => 'dia_chi_cu_the1',
            //     'updated_at' => '2022-06-25 00:27:56',
            // ],
        ];
        \DB::table('history_called')->insert($data);
    }
}
