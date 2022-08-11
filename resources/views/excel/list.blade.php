@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>DANH SÁCH EXCEL IMPORT NGƯỜI DÙNG</h1>

    {{ Breadcrumbs::render('excel') }}

@endsection

@section('content')

<section class="section">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pt-3">
                    <div id="overlay">
                        <div class="cv-spinner">
                            <span class="spinner"></span>
                        </div>
                    </div>
                    <!-- General Form Elements -->
                    <form id="form_import_excel" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="inputText" class="col-sm-2 col-form-label"><b>Chọn file Excel Import</b></label>
                                <span class="badge rounded-pill bg-success instro" role="button" data-bs-toggle="modal" data-bs-target="#fullscreenModal">Hướng dẫn sử dụng</span>
                                <div class="is-show-error"></div>

                                <input class="form-control" name="file" type="file" id="formFile">
                            </div>
                        </div>
                        <a class="btn-import btn btn-primary me-2">Improt File</a>
                        <!-- <a href="{{route('export_customer')}}" class="btn btn-success">Export File</a> -->
                    </form>
                    
                    <div class="modal fade" id="fullscreenModal" tabindex="-1">
                        <div class="modal-dialog modal-fullscreen">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"><b>Hướng Dẫn import Excel</b></h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p class="mb-1"><b>Trường số hợp đồng là trường bắt buộc phải có</b></p>
                              <p class="mb-1"><b>Điền thêm một số trường giống hình mẫu excel sẽ đầy đủ dữ liệu để nhân viên gọi dễ dàng hơn.</b></p>
                              <p for=""><b>Dòng đầu tiên không được để trống</b></p>
                              <img style="width:100%;" src="{{ asset('assets/img/intro.png') }}" alt="">
                            </div>
                          </div>
                        </div>
                    </div><!-- End Full Screen Modal-->
        
                    <!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>

   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body table-responsive">
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
                        <th scope="col text-center">Địa chỉ</th>
                        <th scope="col">Ngày Tạo</th>
                        <th scope="col"></th>
                     </tr>
                  </thead>
                  <tbody>
                    @php
                    $j = $customers->total();
                    if ($customers->currentPage() >= 2) {
                       $j = $customers->total() - (($customers->currentPage() - 1) * $customers->perPage());
                    }
                    @endphp
                    @foreach($customers as $customer)
                     <tr>
                        <th scope="row">{{ $j }}</th>
                        <td>{{ $customer->so_hop_dong }}</td>
                        <td>{{ is_numeric(@$customer->menh_gia) ? number_format(@$customer->menh_gia) : '' }}</td>
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
                        <td>{{ $customer->dia_chi_cu_the }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>
                            <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#basicModal{{$j}}">Xoá</a>
                        </td>
                     </tr>
                    <div class="modal fade" id="basicModal{{$j}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title">Bạn Có Muốn Xóa Khách Hàng?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-center"><b> {{ $customer->ten_kh }}</b></h4>
                                <p><b>Số hợp đồng:</b> {{ $customer->so_hop_dong }}</p>
                                <p><b>Giới tính:</b>
                                @if($customer->gioi_tinh == 'M')
                                Nam
                                @endif
                                @if($customer->gioi_tinh == 'F')
                                Nữ
                                @endif
                                </p>
                                <p><b>Ngày sinh:</b> {{ $customer->ngay_sinh }}</p>
                                <p><b>Số điện thoại:</b> {{ $customer->dien_thoai }}</p>
                                <p><b>Địa chỉ cụ thể:</b> {{ $customer->dia_chi_cu_the }}</p>
                                <p><b>Ngày tạo:</b> {{ $customer->created_at }}</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <a class="btn btn-primary" href="{{ route('delete_excel_import', $customer->id) }}">Đồng ý</a>
                            </div>
                        </div>
                        </div>
                    </div>
                     @php
                    $j--;
                    @endphp
                    @endforeach
                  </tbody>
               </table>
               <!-- End Table with stripped rows -->
               {!! $customers->links('_partials.pagination') !!}
            </div>
         </div>
      </div>
   </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $(".instro").click(function() {
            $(this).trigger('click');
        });

        var formImport = $('#form_import_excel');
        $(".btn-import").click(function(event){
            event.preventDefault();
            $("#overlay").show();

            var formData = new FormData();
            if ($('#formFile').get(0).files.length !== 0) {
                formData.append('file', $('#formFile')[0].files[0]);
            }
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{route('data_import')}}",
                data: formData,
                type: 'post',
                async: true,
                processData: false,
                contentType: false,
                success:function(response) {
                    $("#overlay").hide();
                    location.reload();
                },
                error: function(errors) {
                    console.log(errors);
                    toastr.error('Import dữ liệu thất bại!')
                    $("#overlay").hide();
                    if (errors.status == 422) {
                        var errorsData = errors.responseJSON.errors.file;

                        $.each(errorsData , function (index, value){
                            $(".is-show-error").html(
                                `<div class="alert alert-danger alert-dismissible fade show d-block" role="alert">
                                ${value}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                            );
                        });
                    }
                    if (errors.status == 400 || errors.status == 500) {
                        var error = errors.responseJSON.message;
                        $(".is-show-error").html(
                            `<div class="alert alert-danger alert-dismissible fade show d-block" role="alert">
                                ${error}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                        );
                    }
                }
            });
        });
    })
</script>
@endpush
