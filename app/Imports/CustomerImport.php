<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CustomerImport extends DefaultValueBinder implements ToModel, WithChunkReading, WithValidation, SkipsEmptyRows, WithCustomValueBinder
{
    const RUN_EVERY_TIME = 500;

    // set the preferred date format
    private $date_format = 'd/m/Y';

    // set the columns to be formatted as dates
    private $date_columns = ['P'];

    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), $this->date_columns)) {
            $cell->setValueExplicit(Date::excelToDateTimeObject($value)->format($this->date_format), DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function rules(): array
    {
        return [
            '4' => ['required'],//số hợp đồng
            // '5' => ['required'],//ngày tham gia
            // '7' => ['required'],//số tiền
            // '8' => ['required'],//ngày đáo hạn
            // '12' => ['required'],//họ
            // // '13' => ['required'],// tên
            // '14' => ['required'],// giới tính
            // '15' => ['required'],// Ngày sinh => Cột P
            // '16' => ['required'],//tuổi
            // '17' => ['required'],// số điện thoại
            // '19' => ['required'],
            // '20' => ['required'],
            // '21' => ['required'],
            // '22' => ['required'],
        ];
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '4.required' => 'Số hợp đồng không được để trống cột số :attribute.',
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

    public function model(array $row)
    {
        var_dump($row[8]);
        var_dump(Date::excelToDateTimeObject($row[8])->format('YYYY-mm-dd'));
        dd(date_format($row[8], 'YYYY-mm-dd'));
        return Customer::firstOrCreate([
            'type_pay'        => $row[0],
            'name_pay'        => $row[1],
            'id_customer_pay' => $row[2],
            'position'        => $row[3],
            'id_contract'     => $row[4],
            'join_date'       => (!empty($row[5])) ? date_format($row[5], 'YYYY/mm/dd') : '',
            'note'            => $row[6],
            'money'           => $row[7],
            'date_due_full'   => (!empty($row[8])) ? date_format($row[8], 'YYYY/mm/dd') : '',
            'date_due'        => $row[9],
            'month_due'       => $row[10],
            'year_due'        => $row[11],
            'last_name'       => $row[12],
            'first_name'      => $row[13],
            'sex'             => $row[14],
            'date_birth'      => $row[15],
            'age'             => $row[16],
            'phone'           => $row[17],
            'address_full'    => $row[18],
            'home'            => $row[19],
            'ward'            => $row[20],
            'district'        => $row[21],
            'province'        => $row[22],
        ]);
    }

    public function map($map): array
    {
        return [
            Date::dateTimeToExcel($map[15]),
        ];
    }

    public function columnFormats(): array {
        return [
            'P' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    public function chunkSize(): int
    {
        return self::RUN_EVERY_TIME;
    }
}
