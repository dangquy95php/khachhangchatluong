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
            <div class="col-xxl-4 col-md-6">
               <div class="card info-card customers-card">
                  <div class="card-body">
                     <h5 class="card-title">TỔNG KHÁCH HÀNG IMPORT <span>| Hôm Nay</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ count($dataToday['data']) }}</h6>
                           <span class="text-{{count($dataToday['data']) > count($dataYesterday['data']) ? 'success' : 'danger' }} small pt-1 fw-bold">
                              
                           {{ number_format((count($dataToday['data']) / count($dataYesterday['data'])) * 100 , 1) }}%
                           </span>
                           <span class="text-muted small pt-2 ps-1">{{count($dataToday['data']) < count($dataYesterday['data']) ? 'Giảm' : 'Tăng' }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End Customers Card -->
            <!-- Sales Card -->
            <div class="col-xxl-3 col-md-6">
               <div class="card info-card sales-card">
                  <div class="card-body">
                     <h5 class="card-title">TỔNG KHÁCH ĐÃ GỌI <span>| Hôm Nay</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-headset"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ $dataToday['called'] }}</h6>

                           <span class="text-{{$dataToday['called'] > $dataYesterday['called'] ? 'success' : 'danger' }} small pt-1 fw-bold">
                           {{ number_format(($dataToday['called'] / $dataYesterday['called']) * 100, 1) }}%</span>
                              <span class="text-muted small pt-2 ps-1">{{ $dataToday['called'] < $dataYesterday['called'] ? 'Giảm' : 'Tăng' }}</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End Sales Card -->
            <!-- Revenue Card -->
            <div class="col-xxl-5 col-md-12">
               <div class="card info-card revenue-card">
                  <div class="card-body">
                     <h5 class="card-title">TỔNG TIỀN ĐÃ HẸN KHÁCH <span>| Hôm Nay</span></h5>
                     <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                           <i class="bi bi-currency-dollar"></i>
                        </div>
                        <div class="ps-3">
                           <h6>{{ number_format($dataToday['turnover']) }} VND</h6>
                           <span class="text-{{$dataToday['turnover'] > $dataYesterday['turnover'] ? 'success' 
                           : 'danger'}} small pt-1 fw-bold">
                           {{ number_format(($dataToday['turnover'] / $dataYesterday['turnover']) * 100, 1) }}%</span>
                           <span class="text-muted small pt-2 ps-1">{{ $dataToday['turnover'] < $dataYesterday['turnover'] ? 'Giảm' : 'Tăng' }}</span>
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
                  <table class="table table-borderless">
                     <thead>
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Số Hợp Đồng</th>
                           <th style="min-width: 150px;" scope="col">Tên Khách Hàng</th>
                           <th scope="col">Số Tiền</th>
                           <th scope="col">Giới Tính</th>
                           <th scope="col">Tuổi</th>
                           <th style="min-width: 250px;" scope="col">Địa Chỉ</th>
                           <th style="min-width: 100px;" scope="col">Thời Gian Gọi</th>
                        </tr>
                     </thead>
                     <tbody>

                     @php
                     $i = $dataToday['scheduled']->total();
                     if ($dataToday['scheduled']->currentPage() >= 2) {
                        $i = $dataToday['scheduled']->total() - (($dataToday['scheduled']->currentPage() - 1) * $dataToday['scheduled']->perPage());
                     }
                     @endphp
                     @foreach($dataToday['scheduled'] as $data)
                        <tr>
                           <th scope="row">{{$i}}</th>
                           <td>{{ $data->so_hop_dong }}</td>
                           <td>{{ $data->ten_kh }}</td>
                           <td>{{ is_numeric($data->menh_gia) ? number_format($data->menh_gia) : @$data->menh_gia }}</td>
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
                  {!! $dataToday['scheduled']->links('_partials.pagination') !!}
               </div>
            </div>
         </div>
         <!-- End Recent Sales -->
      <!-- End Left side columns -->
   </div>
</section>

@endsection