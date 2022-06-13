@section('title','Danh sách khách hàng')
@extends('layouts.template')

@section('breadcrumb')

   <h1>DANH SÁCH KHÁCH HÀNG IMPORT</h1>

   {{ Breadcrumbs::render('list_customer') }}

@endsection

@section('content')

<section class="section">
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="p-3">
               <a class="btn btn-primary" href="{{route('delete_customers')}}">XOÁ TẤT CẢ</a>
            </div>
            <div class="card-body">
               <!-- Table with stripped rows -->
               <table class="table table-striped">
                  <thead>
                     <tr>
                     <th scope="col">#</th>
                     <th scope="col">Số hợp đồng</th>
                     <th scope="col">Mệnh Giá</th>
                     <th scope="col">Năm Đáo Hạn</th>
                     <th scope="col">Họ Và Tên</th>
                     <th scope="col">Giới Tính</th>
                     <th scope="col">Ngày Sinh</th>
                     <th scope="col">Điện Thoại</th>
                     <th scope="col">Tuổi</th>
                     <th scope="col text-center">Địa chỉ</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                     <tr>
                        <th scope="row">{{ $customer->id }}</th>
                           <td>{{ $customer->so_hop_dong }}</td>
                           <td>{{ is_numeric($customer->menh_gia) ? number_format($customer->menh_gia) : '' }}</td>
                           <td>{{ $customer->nam_dao_han }}</td>
                           <td>{{ $customer->ten_kh }}</td>
                           <td>
                              @if($customer->gioi_tinh == 'M')
                              Nam
                              @endif
                              @if($customer->gioi_tinh == 'F')
                              Nữ
                              @endif
                           </td>
                           <td>{{ $customer->ngay_sinh }}</td>
                           <td>{{ $customer->dien_thoai }}</td>
                           <td>{{ $customer->tuoi }}</td>
                           <td>{{ $customer->dia_chi_cu_the }}</td>
                     </tr>
                    @endforeach
                  </tbody>
               </table>
               <!-- End Table with stripped rows -->
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
