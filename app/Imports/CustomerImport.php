<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\Data\ImportExcel as Import;
class CustomerImport implements ToCollection, ShouldQueue, WithChunkReading, WithStartRow, WithHeadingRow
{
    const RUN_EVERY_TIME = 200;

    // set the preferred date format
    private $date_format = 'd/m/Y';

    // set the columns to be formatted as dates

    public function startRow(): int
    {
        return 3;
    }

    public function collection(Collection $userCollections)
    {
        foreach ($userCollections as $key => $customer) {
            dispatch(new Import($customer));
        }
    }


    public function rules(): array
    {
        return [
            'so_hop_dong' => ['required'],//số hợp đồng
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'so_hop_dong.required' => 'Số hợp đồng không được để trống cột số :attribute.',
            // '5.required' => 'Ngày tham không được để trống cột số :attribute.',
            // '7.required' => 'Số tiền không được để trống cột số :attribute.',
            // '8.required' => 'Ngày đáo hạn không được để trống cột số :attribute.',
            // '12.required' => 'Họ tên không được để trống cột số :attribute.',
            // '14.required' => 'Giới tính không được để trống cột số :attribute.',
            // '15.required' => 'Ngày sinh không được để trống cột số :attribute.',
            // '16.required' => 'Tuổi không được để trống cột số :attribute.',
            // '17.required' => 'Số điện thoại không được để trống cột số :attribute.',
            // '19.required' => 'Địa chỉ không được để trống cột số :attribute.',
            // '20.required' => 'Đường không được để trống cột số :attribute.',
            // '21.required' => 'Thị xã không được để trống cột số :attribute.',
            // '22.required' => 'Tỉnh không được để trống cột số :attribute.',
        ];
    }

    // public function model(array $row)
    // {
    //     $data = Customer::where('so_hop_dong', $row['so_hop_dong'])->first();
    //     if (!$data) {
    //         return Customer::create([
    //             'so_thu_tu'        => @$row['so_thu_tu'],
    //             'vpbank'           => @$row['vpbank'],
    //             'msdl'             => @$row['msdl'],
    //             'cv'               => @$row['cv'],
    //             'so_hop_dong'      => $row['so_hop_dong'],
    //             'menh_gia'         => @$row['menh_gia'],
    //             'nam_dao_han'      => @$row['nam_dao_han'],
    //             'ten_kh'           => @$row['ten_kh'],
    //             'gioi_tinh'        => @$row['gioi_tinh'],
    //             'ngay_sinh'        => @$row['ngay_sinh'],
    //             'tuoi'             => @$row['tuoi'],
    //             'dien_thoai'       => @$row['dien_thoai'],
    //             'dia_chi_cu_the'   => @$row['dia_chi_cu_the'],
    //         ]);
    //     }
    // }

    public function map($map): array
    {
        return [
            Date::dateTimeToExcel($map[15]),
        ];
    }

    // public function columnFormats(): array {
    //     return [
    //         'P' => NumberFormat::FORMAT_DATE_DDMMYYYY
    //     ];
    // }

    public function chunkSize(): int
    {
        return self::RUN_EVERY_TIME;
    }
}
