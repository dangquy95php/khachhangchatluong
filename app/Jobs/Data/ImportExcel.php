<?php

namespace App\Jobs\Data;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Customer::where('so_hop_dong', $this->customer['so_hop_dong'])->first();

        if (!$data) {
            return Customer::create([
                'so_thu_tu'        => $this->customer['so_thu_tu'],
                'vpbank'           => $this->customer['vpbank'],
                'msdl'             => $this->customer['msdl'],
                'cv'               => $this->customer['cv'],
                'so_hop_dong'      => $this->customer['so_hop_dong'],
                'menh_gia'         => $this->customer['menh_gia'],
                'nam_dao_han'      => $this->customer['nam_dao_han'],
                'ten_kh'           => $this->customer['ten_kh'],
                'gioi_tinh'        => $this->customer['gioi_tinh'],
                'ngay_sinh'        => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->customer['ngay_sinh'])->format('d/m/Y')
                ,
                'tuoi'             => $this->customer['tuoi'],
                'dien_thoai'       => $this->customer['dien_thoai'],
                'dia_chi_cu_the'   => $this->customer['dia_chi_cu_the'],
                'type_result'      => '',
                'comment'          => '',
            ]);
        }
    }
}
