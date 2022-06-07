@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>DANH SÁCH KHU VỰC</h1>

    {{ Breadcrumbs::render('area') }}

@endsection

@section('content')

<section class="section">

   <div class="row">
      <div class="col-lg-7">
         <div class="card">
            <div class="card-body pt-2">
               <!-- Table with stripped rows -->
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên Khu Vực</th>
                        <th scope="col">Trạng Thái</th>
                        <th scope="col">Ngày Tạo</th>
                        <th scope="col">Hành Động</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach($areas as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->status == 1 ? '<span class="badge bg-success">Đang Mở</span>' : '<span class="badge bg-secondary">Chưa kích hoạt</span>' !!}</td>
                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                        <td>
                            <a href="{{route('delete_area', $item->id)}}" class="btn btn-outline-danger">Xoá</a>
                            <a href="{{route('edit_area', $item->id)}}" class="btn btn-outline-primary">Sửa</a>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
               </table>
               <!-- End Table with stripped rows -->
            </div>
         </div>
      </div>
      <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title text-center mb-0"><b>THÊM KHU VỰC</b></h5>
                <!-- Vertical Form -->
                <form class="row g-3" method="post" action="{{ \Request::route()->getName() == 'index_area' ? route('create_area') : '' }}">
                    @csrf
                    <div class="col-12">
                        <label for="inputNanme4" class="form-label">Tên Khu Vực</label>
                        <input type="text" value="{{ @$area->name }}" name="name" class="form-control" id="inputNanme4">
                    </div>
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Trạng Thái</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option selected="0">Vui lòng chọn trạng thái</option>
                            @foreach($area_status as $item)
                                <option {{ @$area->status == $item ? 'selected' : ''; }} value="{{ $item }}">{{ $item == 0 ? 'Chưa kích hoạt' : 'Đang mở'; }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Tạo Mới</button>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>
      </div>       
   </div>
</section>
@endsection
