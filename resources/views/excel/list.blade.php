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
                    <!-- General Form Elements -->
                    <form id="form_import_excel" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="inputText" class="col-sm-2 col-form-label"><b>Chọn file Excel Import</b></label>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session()->has('message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {!! session()->get('message') !!}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <input class="form-control" name="file" type="file" id="formFile">
                            </div>
                        </div>
                        <a class="btn-import btn btn-primary me-2">Improt File</a>
                        <a href="{{route('export_customer')}}" class="btn btn-success">Export File</a>
                    </form>
                    <!-- End General Form Elements -->
                </div>
            </div>
        </div>
    </div>

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
                        <th scope="col">Ngày Tham Gia</th>
                        <th scope="col">Mệnh Giá</th>
                        <th scope="col">Năm Đáo Hạn</th>
                        <th scope="col">Họ Và Tên</th>
                        <th scope="col">Giới Tính</th>
                        <th scope="col">Ngày Sinh</th>
                        <th scope="col">Điện Thoại</th>
                        <th scope="col">Tuổi</th>
                        <th scope="col text-center">Địa chỉ</th>
                        <th scope="col">Ngày Tạo</th>
                     </tr>
                  </thead>
                  <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($customers as $customer)
                     <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $customer->so_hop_dong }}</td>
                        <td>{{ @$customer->ngay_tham_gia }}</td>
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
                        <td>{{ $customer->tuoi }}</td>
                        <td>{{ $customer->dia_chi_cu_the }}</td>
                        <td>{{ $customer->created_at }}</td>
                     </tr>
                     @php
                    $i++;
                    @endphp
                    @endforeach
                  </tbody>
               </table>
               <!-- End Table with stripped rows -->
            </div>
         </div>
         
         {!! $customers->links('_partials.pagination') !!}
      </div>
   </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-import').click(function() {
            var formImport = $('#form_import_excel');
            formImport.attr('action', "{{route('data_import')}}");
            formImport.attr("method", "POST");
            formImport.submit();
        })
    })
</script>
@endpush
