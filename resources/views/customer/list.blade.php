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
            <div class="card-body">
               <!-- Table with stripped rows -->
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Số hợp đồng</th>
                        <th scope="col">Ngày tham gia</th>
                        <th scope="col">Số tiền</th>
                        <th scope="col">Ngày Đáo Hạn</th>
                        <th scope="col">Họ Và Tên</th>
                        <th scope="col">Giới Tính</th>
                        <th scope="col">Ngày Sinh</th>
                        <th scope="col">Địa chỉ</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach($customers as $customer)
                     <tr>
                        <th scope="row">{{ $customer->id }}</th>
                        <td>{{ $customer->id_contract }}</td>
                        <td>{{ date('Y-m-d', strtotime($customer->join_date)) }}</td>
                        <td>{{ number_format($customer->money); }}</td>
                        <td>{{ $customer->date_due .'-'. $customer->month_due .'-'. $customer->year_due }}</td>
                        <td>{{ $customer->last_name .' '. $customer->first_name}}</td>
                        <td>{{ $customer->sex == 'M' ? 'Nam' : 'Nữ' }}</td>
                        <td>{{ $customer->date_birth }}</td>
                        <td>{{ $customer->home .', '. $customer->ward .', '. $customer->district .', '. $customer->province }}</td>
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
