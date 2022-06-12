@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>QUẢNG LÝ KHÁCH HÀNG THEO TỪNG KHU VỰC</h1>

    {{ Breadcrumbs::render('customer_by_area') }}

@endsection

@section('content')

<section class="section">
    <form action="" method="post" id="form-customer">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Quản Lý Khách Hàng Theo Từng Vực</h5>
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="inputNanme4" class="form-label">Khu Vực:</label>
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}
                                                @endforeach
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <select id="inputState" name="area" class="form-select">
                                            <option value="">Chọn nhân viên</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id .'_'. $area->name }}">{{$area->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="from_row" onkeyup="if(parseInt(this.value) > 2000 || parseInt(this.value) < 1){ this.value = ''; return false; }"  class="from_row form-control" value="{{ old('from_row') }}" placeholder="Từ dòng số">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="to_row" value="{{ old('to_row') }}" onkeyup="if(parseInt(this.value) > 2000 || parseInt(this.value) < 1){ this.value = ''; return false; }" class="to_row form-control" placeholder="Đến số dòng">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <a href="#" id="btn-submit-customer" class="btn btn-primary">Đăng Ký</a>
                            </div>
                        </div>
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
                            <th scope="col">Chọn</th>
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
                        @php
                        $i = 1;
                        @endphp
                        @foreach($customers as $customer)
                        <tr>
                            <th scope="row">{{ $customer->id }}</th>
                            <th class="customer_choose">
                                <div class="form-check d-flex justify-content-center">
                                    <input name="choose_customers[]" class="form-check-input" type="checkbox" value="{{ $customer->id }}" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                    </label>
                                </div>
                            </th>
                            <td>{{ $customer->so_hop_dong }}</td>
                            <td>{{ number_format($customer->menh_gia) ?? '' }}</td>
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
                        @php
                        $i++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>

                {!! count($customers) == 0 ? '<h5 class="text-center pt-5 pb-5"><b>ĐÃ CẤP HẾT DỮ LIỆU CHO CÁC KHU VỰC</b></h5>' : '' !!}
                <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
   </form>
</section>

@endsection

@push('scripts')
<script>


$( "#btn-submit-customer" ).click(function() {
    var from_row = $('.from_row').val() || 0;
    var to_row = $('.to_row').val() || 0;

    var checked = false;
    $( ".table .customer_choose input" ).each(function( index ) {
        if ($(this).is(':checked')) {
            checked = true;
        }
    })

    if (!checked) {
        if (from_row == '') {
            from_row = 0;
        }
        if (to_row == '') {
            to_row = 0;
        }
    }
    $( ".table .customer_choose input" ).each(function( index ) {
        if (index < Number(to_row) ) {
            $(this).prop('checked', true);
        } else {
            return;
        }
    });

    if ($( ".table .customer_choose input" ).length > 0) {
        $( "#form-customer" ).submit();
    } else {
        alert("Vui lòng import dữ liệu excel vào hệ thống!");
    }
});

</script>
@endpush
