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
use Maatwebsite\Excel\Concerns\SkipsFailures;
use App\Jobs\Data\ImportExcel as Import;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class CustomerImport implements ToCollection, ShouldQueue, WithChunkReading, WithStartRow, WithHeadingRow, SkipsOnFailure, SkipsEmptyRows, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    const RUN_EVERY_TIME = 100;

    // set the preferred date format
    private $date_format = 'd/m/Y';

    // set the columns to be formatted as dates

    public function startRow(): int
    {
        return 2;
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
        ];
    }

    public function map($map): array
    {
        return [
            Date::dateTimeToExcel($map[15]),
        ];
    }

    public function chunkSize(): int
    {
        return self::RUN_EVERY_TIME;
    }
}
