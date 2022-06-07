@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')
  
   <h1>DANH SÁCH NGƯỜI DÙNG</h1>

   {{ Breadcrumbs::render('list_account') }}
    
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
                        <th scope="col">Tên Nhân Viên</th>
                        <th scope="col">Tên Đăng Nhập</th>
                        <th scope="col">Email</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Ngày Đăng Ký</th>
                        <th scope="col" class="text-center">
                            <button type="button" class="btn btn-primary">Thêm</button>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($data as $item)
                     <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{$item->name}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                           @if ($item->status == 1) 
                              <span class="badge rounded-pill bg-success">Đang hoạt động</span>
                           @endif

                           @if($item->status == 2)
                              <span class="badge rounded-pill bg-danger">Không hoạt động</span>
                           @endif

                           @if($item->status == 0)
                              <span class="badge rounded-pill bg-secondary">Chưa được duyệt</span>
                           @endif
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning text-white">Sửa</button>
                            <button type="button" class="btn btn-danger">Xoá</button>
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