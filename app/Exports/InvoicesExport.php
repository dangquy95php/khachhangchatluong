<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoicesExport implements ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
        ];
    }
}
