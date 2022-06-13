<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use App\Jobs\Data\ImportExcel as Import;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;


class CustomerImport implements ToModel, ShouldQueue, WithChunkReading, WithHeadingRow, SkipsOnError
{

    use Importable, SkipsFailures, SkipsErrors, Dispatchable, SerializesModels, Queueable;

    const RUN_EVERY_TIME = 100;

    // set the preferred date format
    private $date_format = 'd/m/Y';

    // set the columns to be formatted as dates

    public function headingRow(): int
    {
        return 2;
    }

    // public function collection(Collection $userCollections)
    // {
    //     foreach ($userCollections as $key => $customer) {
    //         dispatch(new Import($customer));
    //     }
    // }

    public function model(array $row)
    {
        $data = Customer::where('so_hop_dong', $row['so_hop_dong'])->first();

        if (!$data) {
            $customer = Customer::create([
                'so_thu_tu'        => $row['so_thu_tu'],
                'vpbank'           => $row['vpbank'],
                'msdl'             => $row['msdl'],
                'cv'               => $row['cv'],
                'so_hop_dong'      => $row['so_hop_dong'],
                'menh_gia'         => $row['menh_gia'],
                'nam_dao_han'      => $row['nam_dao_han'],
                'ten_kh'           => (isset($row['ho']) && isset($row['ten'])) ? $row['ho'] .' '. $row['ten'] : $row['ten_kh'],
                'gioi_tinh'        => $row['gioi_tinh'],
                'ngay_sinh'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_sinh'])->format('d/m/Y'),
                'tuoi'             => $row['tuoi'],
                'dien_thoai'       => $row['dien_thoai'],
                'dia_chi_cu_the'   => $row['dia_chi_cu_the'],
                'type_result'      => '',
                'comment'          => '',
            ]);

            dispatch(new Import($customer));

            return $customer;
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
        ];
    }

    // public function map($map): array
    // {
    //     return [
    //         Date::dateTimeToExcel($map[15]),
    //     ];
    // }

    public function chunkSize(): int
    {
        return self::RUN_EVERY_TIME;
    }
}
