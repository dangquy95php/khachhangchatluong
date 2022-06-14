<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::select('id','so_thu_tu','vpbank','msdl','cv','so_hop_dong','menh_gia','nam_dao_han','ho','ten','ten_kh','gioi_tinh','ngay_sinh','tuoi','dien_thoai','dia_chi_cu_the','type_result','comment')->get();
    }

    public function headings() :array {
    	return ["ID", "Số thứ tự", "VP/Bank	CV", "Số hợp đồng", "Mệnh Giá", "Năm Đáo Hạn", "Họ", "Tên", "Tên KH", "Giới Tính", "Ngày Sinh", "Tuổi", "Điện Thoại", "Địa chỉ cụ thể"];
    }
}
