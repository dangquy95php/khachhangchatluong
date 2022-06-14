<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::all();
    }

    public function headings() :array {
    	return ["Số thứ tự", "VP/Bank	CV", "Số hợp đồng", "Mệnh Giá", "Năm Đáo Hạn", "Họ", "Tên", "Tên KH", "Giới Tính", "Ngày Sinh", "Tuổi", "Điện Thoại", "Địa chỉ cụ thể"];
    }
}
