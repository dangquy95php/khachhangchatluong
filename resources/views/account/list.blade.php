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
                        <th scope="col">
                            <button type="button" class="btn btn-primary">Thêm</button>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">1</th>
                        <td>Brandon Jacob</td>
                        <td>Designer</td>
                        <td>28</td>
                        <td><span class="badge rounded-pill bg-primary">Đang hoạt động</span></td>
                        <td>2016-05-25</td>
                        <td>
                            <button type="button" class="btn btn-warning text-white">Sửa</button>
                            <button type="button" class="btn btn-danger">Xoá</button>
                        </td>
                     </tr>
                     <tr>
                        <th scope="row">2</th>
                        <td>Bridie Kessler</td>
                        <td>Developer</td>
                        <td>35</td>
                        <td><span class="badge rounded-pill bg-danger">Không hoạt động</span></td>
                        <td>2014-12-05</td>
                        <td>
                            <button type="button" class="btn btn-warning text-white">Sửa</button>
                            <button type="button" class="btn btn-danger">Xoá</button>
                        </td>
                     </tr>
                     <tr>
                        <th scope="row">3</th>
                        <td>Ashleigh Langosh</td>
                        <td>Finance</td>
                        <td>45</td>
                        <td><span class="badge rounded-pill bg-secondary">Chưa được duyệt</span></td>
                        <td>2011-08-12</td>
                        <td>
                            <button type="button" class="btn btn-warning text-white">Sửa</button>
                            <button type="button" class="btn btn-danger">Xoá</button>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <!-- End Table with stripped rows -->
            </div>
         </div>
      </div>
   </div>
</section>
@endsection