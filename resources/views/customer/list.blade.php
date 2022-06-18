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
            <form class="pt-3" method="GET" action="{{ route('customer.delete') }}">
               @csrf
               <div class="row">
                  <div class="col-md-3 col-md-5 col-sm-5">
                     <div class="row p-2">
                        <label for="inputTime" class="col-md-5 col-form-label text-md-end text-sm-start"><b>Ngày bắt đầu:</b></label>
                        <div class="col-md-7">
                           <input type="date" name="start_date" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-md-5 col-sm-5">
                     <div class="row p-2">
                        <label for="inputTime" class="col-md-5 col-form-label text-md-end text-sm-start"><b>Ngày kết thúc:</b></label>
                        <div class="col-md-7">
                           <input type="date" name="end_date" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-2">
                     <div class="p-md-2 p-sm-0">
                        <button type="submit" class="btn btn-success">Xoá</button>
                     </div>
                  </div>
               </div>
            </form>
            <hr/>
            <div class="card-body">
               <!-- Table with stripped rows -->
               <table class="table table-striped">
                  <thead>
                     <tr>
                     <th scope="col">#</th>
                     <th scope="col">Số hợp đồng</th>
                     <th scope="col">Ngày tham gia</th>
                     <th scope="col">Mệnh Giá</th>
                     <th scope="col">Năm Đáo Hạn</th>
                     <th scope="col">Họ Và Tên</th>
                     <th scope="col">Giới Tính</th>
                     <th scope="col">Ngày Sinh</th>
                     <th scope="col">Điện Thoại</th>
                     <th scope="col">Tuổi</th>
                     <th scope="col text-center">Địa chỉ</th>
                     <th scope="col text-center">Ngày Tạo</th>
                     <th scope="col"></th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                     <tr>
                        <th scope="row">{{ $customer->id }}</th>
                           <td>{{ $customer->so_hop_dong }}</td>
                           <td>{{ $customer->ngay_tham_gia }}</td>
                           <td>{{ is_numeric(@$customer->menh_gia) ? number_format(@$customer->menh_gia) : @$customer->menh_gia }}</td>
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
                           <td>{{ $customer->created_at }}</td>
                           <td>
                              <a class="btn btn-danger" href="{{ route('customer.delete.byId', $customer->id) }}">Xoá</a>
                           </td>
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
