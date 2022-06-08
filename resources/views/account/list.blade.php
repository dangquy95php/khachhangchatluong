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
                            <a href="{{ route('create_account') }}" type="button" class="btn btn-primary">Thêm</a>
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
                            <a class="btn btn-warning text-white" href="{{route('edit_account', $item->id) }}">Sửa</a>
                            <a data-bs-target="#deleteModal{{ $item->id }}" data-bs-toggle="modal"  href="{{route('delete_account', $item->id) }}" class="btn btn-danger">Xoá</button>
                        </td>
                     </tr>
                     <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Bạn Có Muốn Xoá Không?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Tên Đăng Nhập: <b>{{ $item->username }}</b></p>
                                <p>Email: <b>{{ $item->email }}</b></p>
                                <p>Trạng Thái:
                                    @if($item->status == 1)
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    @endif
                                    @if($item->status == 2)
                                        <span class="badge bg-danger">Không hoạt động</span>
                                    @endif
                                    @if($item->status == 0)
                                        <span class="badge bg-secondary">Chưa kích hoạt</span>
                                    @endif
                                </p>
                                <p>Ngày Đăng Ký: {{ $item->created_at }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <a type="button" href="{{route('delete_account', $item->id) }}" class="btn btn-primary">Đồng Ý</a>
                            </div>
                            </div>
                        </div>
                    </div>
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
