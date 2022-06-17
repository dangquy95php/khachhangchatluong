<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 100px;
        }
    </style>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">Sales Khách Hàng</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="GET" action="{{ route('search_customer') }}">
                <input type="text" name="query" placeholder="Tìm kiếm khách khách hàng" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <!-- End Search Bar -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>
                <!-- End Search Icon-->

                <!-- End Messages Nav -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/img-prudential.jpg') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span>
                    </a><!-- End Profile Iamge Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <!-- <li class="dropdown-header">
                        <h6>Kevin Anderson</h6>
                        <span>Web Designer</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                        <i class="bi bi-person"></i>
                        <span>My Profile</span>
                        </a>
                    </li> -->
                        <!-- <li>
                        <hr class="dropdown-divider">
                    </li> -->
                        @if (Auth::user()->role == 2)
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin') }}">
                                    <i class="ri-admin-line"></i>
                                    <span>Trang Quản Trị</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng Xuất</span>
                            </a>
                        </li>
                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>

    <!-- End Sidebar-->

    <main style="margin-top:80px;">

        <div class="card">
            <div class="card-body px-3">
                <h5 class="card-title mb-0">PHẦN MỀM CHĂM SÓC KHÁCH HÀNG</h5>

                <div class="card pt-3 mb-3">
                    <div class="card-body">
                        <!-- Vertical Form -->
                        <form method="POST" action="" class="row g-3" id="customerForm">
                            <input type="text" class="d-none" name="id" value="{{ @$customer->id }}" />
                            @csrf
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-5 col-md-8 col-sm-12 pe-1">
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                            <label for="inputEmail4" class="form-label"><b>Ngày Tham Gia</b></label>
                                            <input type="text" class="form-control"
                                                value="{{ @$customer->ngay_tham_gia }}" id="ngay_tham_gia"
                                                name="ngay_tham_gia">
                                            </div>
                                            <div class="col-sm-6">
                                            <label for="inputNanme4" class="form-label"><b>Năm Đáo Hạn</b></label>
                                            <input id="nam_dao_han" name="nam_dao_han" class="form-control"
                                                type="text" value="{{ @$customer->nam_dao_han }}" />
                                            </div>
                                            <div class="pe-0 col-sm-6">
                                            <label for="inputPassword4" class="form-label"><b>Số Hợp
                                            Đồng</b></label>
                                            <input type="text" disabled name="id_contract"
                                                value="{{ @$customer->so_hop_dong }}" id="id_contract"
                                                class="form-control" id="inputPassword4">
                                            </div>
                                            <div class="col-sm-6">
                                            <label for="inputEmail4" class="form-label"><b>Số Tiền</b></label>
                                            <input type="text" class="form-control"
                                                value="{{ number_format((int) @$customer->menh_gia) }}"
                                                id="menh_gia" name="money">
                                            </div>
                                            <div class="col-8">
                                            <label for="inputNanme4" class="form-label"><b>Họ Và Tên</b></label>
                                            <input type="text" value="{{ @$customer->ten_kh }}" name="last_name"
                                                class="form-control" id="ten_kh">
                                            </div>
                                            <div class="col-4">
                                                <label for="inputNanme4" class="form-label"><b>Số Điện Thoại</b></label>
                                                <input type="text" name="phone" value="{{ @$customer->dien_thoai }}" class="form-control" id="dien_thoai">
                                            </div>
                                            <div class="col-12">
                                            <label for="inputPassword4" class="form-label"><b>Địa Chỉ</b></label>
                                            <input type="text" value="{{ @$customer->dia_chi_cu_the }}"
                                                name="address_full" id="dia_chi_cu_the" class="form-control"
                                                id="inputPassword4">
                                            </div>
                                            <div class="col-md-2 col-sm-6 pe-0">
                                            <label for="inputPassword4" class="form-label"><b>Tuổi</b></label>
                                            <input type="number" value="{{ @$customer->tuoi }}" name="age"
                                                id="tuoi" min="1" max="200"
                                                onkeyup="if(parseInt(this.value) > 200 || parseInt(this.value) < 1){ this.value = ''; return false; }"
                                                class="form-control" id="inputPassword4">
                                            </div>
                                            <div class="col-md-3 col-sm-6">
                                            <label for="inputEmail4" class="form-label"><b>Giới Tính</b></label>
                                            <select name="sex" id="gioi_tinh" class="form-select">
                                                <option selected="">Chọn giới tính...</option>
                                                <option {{ @$customer->gioi_tinh === 'M' ? 'selected' : '' }}
                                                value="M">Nam</option>
                                                <option {{ @$customer->gioi_tinh === 'F' ? 'selected' : '' }}
                                                value="F">Nữ</option>
                                            </select>
                                            </div>
                                            <div class="col-md-7 col-sm-12">
                                            <label for="inputEmail4" class="form-label"><b>Nguồn Dữ
                                            Liệu</b></label>
                                            <select name="area_name" id="data_area_id" class="form-select">
                                                <option value="">Chọn nguồn dữ liệu</option>
                                                @foreach ($areas as $area)
                                                <option
                                                {{ old('area_name', @$customer->area_id) == $area->id ? 'selected' : '' }}
                                                value="{{ $area->id }}">{{ $area->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            </div>
                                            @error('area_name')
                                            <div class="text-danger text-end mt-1"> {{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 px-md-1 mt-md-0 mt-sm-3">
                                        <label for="inputEmail4" class="form-label"><b>Kết Quả Gọi</b></label>
                                        <ul class="list-group is-result">
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result" value="0" id="gridRadios1"
                                                {{ old('type_result', @$customer->type_result) == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios1">
                                                Đã hẹn
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="1" id="gridRadios2"
                                                {{ old('type_result', @$customer->type_result) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios2">
                                                Đại lý vẫn chăm sóc
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="2" id="gridRadios3"
                                                {{ old('type_result', @$customer->type_result) == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios3">
                                                Khách hàng ít tiền
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="3" id="gridRadios4"
                                                {{ old('type_result', @$customer->type_result) == 3 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios4">
                                                Khách hàng suy nghĩ, gọi lại sau
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result" value="4" id="gridRadios5"
                                                {{ old('type_result', @$customer->type_result) == 4 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios5">
                                                KNM / Bận / Tắt máy / Sai số / Đổi số
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="5" id="gridRadios6"
                                                {{ old('type_result', @$customer->type_result) == 5 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios6">
                                                Hợp đồng Hủy / Đáo hạn / Hoàn trả giá trị
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="6" id="gridRadios7"
                                                {{ old('type_result', @$customer->type_result) == 6 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios7">
                                                Đã tham gia hợp đồng mới / Không tham gia
                                                </label>
                                            </div>
                                            </li>
                                            <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type_result"
                                                value="7" id="gridRadios8"
                                                {{ old('type_result', @$customer->type_result) == 7 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gridRadios8">
                                                Khác
                                                </label>
                                            </div>
                                            </li>
                                        </ul>
                                        @include('_partials.alert', ['field' => 'type_result'])
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-6 mt-lg-0 mt-md-4 mt-sm-3 px-md-1">
                                        <div class="col-12 col-sm-12">
                                            <!-- <textarea class="form-control" placeholder="Ghi chú cụ thể thông tin khách hàng" id="floatingTextarea" rows="5"></textarea> -->
                                            <div class="card mb-2">
                                                <div class="card-body">
                                                    <h5 class="card-title pt-3 pb-0"><b>Ghi Chú</b></h5>
                                                    <textarea name="comment" id="comment" value="{{ @$customer->comment }}" class="form-control" rows="10">{{ old('comment', @$customer->comment) }}</textarea>
                                                    <!-- End Quill Editor default -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <!-- <button type="button" class="btn btn-danger"><i class="bi bi-exclamation-octagon"></i><span class="ps-2">Reset Dữ liệu</span></button> -->
                                            <button type="submit" class="btn-save btn btn-success" name="action" value="save">
                                                <i class="bi bi-check-circle"></i><span class="ps-2">Lưu Dữ
                                                    Liệu</span>
                                            </button>

                                            <button type="submit" class="btn-next btn btn-outline-primary" name="action"
                                                value="next">
                                                <span class="pe-1">Gọi Tiếp Theo</span>
                                                <i class="bi bi-chevron-double-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </form><!-- Vertical Form -->
                    </div>
                </div>
                <!-- Default Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">Lịch sử đã gọi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Danh sách đã gọi</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="myTabContent">
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">

                        <div class="col-12">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3 col-md-5 col-sm-5">
                                        <div class="row p-2">
                                            <label for="inputTime" class="col-md-5 col-form-label text-md-end text-sm-start"><b>Ngày bắt đầu:</b></label>
                                            <div class="col-md-7">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-5 col-sm-5">
                                        <div class="row p-2">
                                            <label for="inputTime" class="col-md-5 col-form-label text-md-end text-sm-start"><b>Ngày kết thúc:</b></label>
                                            <div class="col-md-7">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <div class="p-md-2 p-sm-0">
                                            <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade active show" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                        <div class="card mb-2 mt-md-2 mt-sm-3">
                            <div class="card-body pt-3 table-responsive">
                                {{ count($dataHistory) == 0 ? `<h5 class="text-center"><b>Dữ Liệu Chưa Có</b></h5>` : '' }}
                                <!-- Table with hoverable rows -->
                                <table class="table table-hover" style="min-width: 1000px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Ngày Tham Gia</th>
                                            <th scope="col">Năm Đáo Hạn</th>
                                            <th scope="col">Số Hợp Đồng</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Tuổi</th>
                                            <th scope="col">Số Điện Thoại</th>
                                            <th scope="col">Ghi Chú</th>
                                            <th scope="col">Mệnh Giá</th>
                                            <th scope="col">Kết Quả Cuộc Gọi</th>
                                            <th scope="col">Ngày Gọi</th>
                                            <th scope="col">Địa Chỉ</th>
                                            <th scope="col">Giới Tính</th>
                                            <th scope="col">Nguồn Dữ Liệu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($dataHistory as $data)
                                        <tr role="button" class="is-item-customer">
                                            <th scope="row">{{ $i }}</th>
                                            <td class="ngay_tham_gia">{{ @$data->ngay_tham_gia }}</td>
                                            <td class="nam_dao_han">{{ @$data->nam_dao_han }}</td>
                                            <td class="so_hop_dong">{{ $data->so_hop_dong }}</td>
                                            <td class="ten_kh">{{ $data->ten_kh }}</td>
                                            <td class="tuoi">{{ $data->tuoi }}</td>
                                            <td class="dien_thoai">{{ $data->dien_thoai }}</td>
                                            <td class="comment">{{ $data->comment }}</td>
                                            <td class="comment">{{ $data->menh_gia }}</td>
                                            <td class="type_result">
                                                @foreach (\App\Models\Customer::getInforOption() as $key => $value)
                                                @if ($key == $data->type_result)
                                                <span data-id="{{ $key }}" class="badge bg-primary">{{ $value }}</span>
                                                @endif
                                                @endforeach
                                            </td>
                                            <td class="updated_at">{{ $data->updated_at }}</td>
                                            <td class="dia_chi_cu_the">{{ $data->dia_chi_cu_the }}</td>
                                            <td class="gioi_tinh">
                                                @if($data->gioi_tinh === 'M')
                                                Nam
                                                @elseif($data->gioi_tinh === 'F')
                                                Nữ
                                               @endif
                                            </td>
                                            <td class="area_name">{{ $data->name }}</td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table with hoverable rows -->
                            </div>
                        </div>
                    </div><!-- End Default Tabs -->
                </div>
            </div>

            <!-- Disabled Backdrop Modal -->
            <button type="button" class="btn-alert p-0 d-none" data-bs-toggle="modal" data-bs-target="#disablebackdrop"></button>
            <div class="modal fade" id="disablebackdrop" tabindex="-1" data-bs-backdrop="false" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">THÔNG BÁO</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Bạn đã sử dụng hết dữ liệu. Vui lòng liên hệ với quản trị viên để cấp dữ liệu thêm.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đã Hiểu</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Disabled Backdrop Modal-->
    </main>

    <footer class="footer">
        <div class="copyright">
            © Copyright <strong><span>PxwebShop</span></strong>. Đã đăng ký bản quyền
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Thiết kế bởi <a href="https://pxwebshop.com/">Công Ty TNHH PxwebShop</a>
        </div>
    </footer>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Jquery Slim JS -->
    <script src="{{ asset('js/jquery.min.js') }} "></script>

    <script src="{{ asset('js/jquery-ui.min.js') }} "></script>

    <svg id="SvgjsSvg1145" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1146"></defs>
        <polyline id="SvgjsPolyline1147" points="0,0"></polyline>
        <path id="SvgjsPath1148"
            d="M-1 270.2L-1 270.2C-1 270.2 176.9170673076923 270.2 176.9170673076923 270.2C176.9170673076923 270.2 294.86177884615387 270.2 294.86177884615387 270.2C294.86177884615387 270.2 412.80649038461536 270.2 412.80649038461536 270.2C412.80649038461536 270.2 530.7512019230769 270.2 530.7512019230769 270.2C530.7512019230769 270.2 648.6959134615385 270.2 648.6959134615385 270.2C648.6959134615385 270.2 766.640625 270.2 766.640625 270.2C766.640625 270.2 766.640625 270.2 766.640625 270.2 ">
        </path>
    </svg>

    <script src="{{ asset('js/toastr.min.js') }} "></script>

    <script>
        $(document).ready(function() {
            if (!$('#id_contract').val()) {
                $('.btn-alert').trigger('click');
            }
            $(".is-item-customer").click(function() {
                var el= $(this).get(0);

                $('#ngay_tham_gia').val($($(el).find('.ngay_tham_gia').get(0)).text());
                $('#nam_dao_han').val($($(el).find('.nam_dao_han').get(0)).text());
                $('#id_contract').val($($(el).find('.so_hop_dong').get(0)).text());
                $('#menh_gia').val($($(el).find('.menh_gia').get(0)).text());
                $('#ten_kh').val($($(el).find('.ten_kh').get(0)).text());
                $('#dien_thoai').val($($(el).find('.dien_thoai').get(0)).text());
                $('#dia_chi_cu_the').val($($(el).find('.dia_chi_cu_the').get(0)).text());
                $('#tuoi').val($($(el).find('.tuoi').get(0)).text());
                $('#data_area_id').val($($(el).find('.area_id').get(0)).text());
                $('#comment').val($($(el).find('.comment').get(0)).text());
                var id_result = $($(el).find('.type_result')).children().data('id');

                var sex = $($(el).find('.gioi_tinh').get(0)).text().trim();
                $("#gioi_tinh option").each(function() {
                    $(this).attr('selected', false);
                    if ($(this).text().trim() == sex) {
                        $(this).attr('selected', true);
                    } else if($(this).text().trim() == sex) {
                        $(this).attr('selected', true);
                    }
                });

                var area_text = $($(el).find('.area_name').get(0)).text().trim();

                $("#data_area_id option").each(function() {
                    if ($(this).text().trim() == area_text) {
                        $(this).prop("selected","selected");
                    }
                });

                $('.is-result .list-group-item').each(function() {
                    var value_radio = $($(this).find('input').get(0)).val();
                    if (value_radio  == id_result) {
                        $($(this).find('input').get(0)).attr('checked', true);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var id = 0;
            //get
            $('body').on('click', '#editCustomer', function(event) {
                id = $(this).data('id');
                console.log(id);
                $.get('customer/' + id + '/edit', function(data) {
                    // $('#userCrudModal').html("Edit category");
                    // $('#submit').val("Edit category");
                    $('#staticBackdrop').modal('show');
                    $('#ngay_bat_dau').val($($(el).find('.so_hop_dong').get(0)).text());
                    $('#nam_dao_han').val(data.data.nam_dao_han);
                    $('#so_hop_dong').val(data.data.so_hop_dong);
                    $('#menh_gia').val(data.data.menh_gia);
                    $('#ten_kh').val(data.data.ten_kh);
                    $('#dien_thoai').val(data.data.dien_thoai);
                    $('#dia_chi_cu_the').val(data.data.dia_chi_cu_the);
                    $('#tuoi').val(data.data.tuoi);
                    $('.gioi_tinh').val(data.data.gioi_tinh);
                    $('.area_id').val(data.data.area_id);
                    $('#comment').val(data.data.comment);
                    $('#type_result').val(data.data.type_result);
                })
            });

            //post
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#submit', function(event) {
                var type_result = $(".form-check-input:checked").val();
                var comment = $("#comment").val();
                $.ajax({
                    url: 'customer/' + id,
                    type: "POST",
                    data: {
                        id: id,
                        type_result: type_result,
                        comment: comment,
                    },
                    dataType: 'json',
                    success: function(data) {
                        window.location.reload(true);
                    },
                    error: function (err) {
                        if (err.status == 422) {
                            alert('Vui lòng chọn kết quả gọi');
                        }
                    }
                });
            });

        });
    </script>

    {!! Toastr::message() !!}

</body>

</html>
