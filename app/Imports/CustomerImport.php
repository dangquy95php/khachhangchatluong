<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel
{
    public function model(array $row)
    {
        dd($row);die;
        return new Customer([
            'username' => $row['username'] ?? $row['ten_tai_khoan'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? $row['mat_khau']),
            'type' => $row['type'] ?? $row['loai']
        ]);
    }
}
