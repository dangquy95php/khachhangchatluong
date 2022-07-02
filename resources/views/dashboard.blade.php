@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>TỔNG QUAN DASHBOARD</h1>

   {{ Breadcrumbs::render('home') }}

@endsection

@section('content')

<section class="section dashboard">
   <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
         <div class="row">
            <!-- Customers Card -->
            <!-- <div class="col-xxl-4 col-md-6">
               <div class="card info-card customers-card">
                  <div class="card-body">
                     <h5 class="card-title">TỔNG KHÁCH HÀNG IMPORT <span>| Hôm Nay</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-people"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div> -->
            <!-- End Customers Card -->
            <!-- Sales Card -->
            <div class="col-xxl-6 col-md-6">
               <div class="card info-card sales-card">
                  <div class="card-body">
                     <h5 class="card-title">TỔNG KHÁCH ĐÃ GỌI <span>| Hôm Nay</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-headset"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $totalCallCurrent }}</h6>

                           <span class="text-{{$totalCallCurrent > $totalCalledBefore ? 'success' : 'danger' }} small pt-1 fw-bold">
                              @if($totalCallCurrent != 0 && $totalCalledBefore != 0)
                                 {{ number_format(($totalCallCurrent / $totalCalledBefore) * 100, 1) }}%
                              @endif
                           </span>
                           <span class="text-muted small pt-2 ps-1">{{ $totalCallCurrent < $totalCalledBefore ? 'Giảm' : 'Tăng' }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Recent Sales -->
      <div class="col-12">
         <div class="card recent-sales overflow-auto">
            <div class="card-body table-responsive">
               <h5 class="card-title">Khách Hàng Đã Hẹn <span>| Hôm nay</span></h5>
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Số Hợp Đồng</th>
                        <th style="min-width: 150px;" scope="col">Tên Khách Hàng</th>
                        <th scope="col">Số Tiền</th>
                        <th style="min-width: 200px;" scope="col">Ghi Chú</th>
                        <th scope="col">Tài Khoản Gọi</th>
                        <th scope="col">Giới Tính</th>
                        <th scope="col">Tuổi</th>
                        <th style="min-width: 250px;" scope="col">Địa Chỉ</th>
                        <th style="min-width: 100px;" scope="col">Thời Gian Gọi</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i = count($today);
                     @endphp
                     @foreach($today as $data)
                        <tr>
                           <th scope="row">{{$i}}</th>
                           <td>{{ $data->so_hop_dong }}</td>
                           <td>{{ $data->ten_kh }}</td>
                           <td>{{ is_numeric($data->menh_gia) ? number_format($data->menh_gia) : @$data->menh_gia }}</td>
                           <td>{{ $data->comment }}</td>
                           <td>{{ $data->username }}</td>
                           <td>
                              @if($data->gioi_tinh == 'M')
                              Nam
                              @endif
                              @if($data->gioi_tinh == 'F')
                              Nữ
                              @endif
                           </td>
                           <td>{{ $data->tuoi }}</td>
                           <td>{{ $data->dia_chi_cu_the }}</td>
                           <td>{{ $data->updated_at }}</td>
                        </tr>
                     @php
                     $i--;
                     @endphp
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- End Left side columns -->
   </div>
</section>

@endsection
