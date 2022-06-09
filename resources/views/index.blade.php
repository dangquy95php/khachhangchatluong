<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" >

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <style>
        .ql-editor{
            min-height:100px;
        }
    </style>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center">
            <img src="{{asset('assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">Sales Khách Hàng</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->
        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="GET" action="{{route('search_customer')}}">
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
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have 4 new notifications
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-exclamation-circle text-warning"></i>
                        <div>
                            <h4>Lorem Ipsum</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>30 min. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-x-circle text-danger"></i>
                        <div>
                            <h4>Atque rerum nesciunt</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>1 hr. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-check-circle text-success"></i>
                        <div>
                            <h4>Sit rerum fuga</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>2 hrs. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="notification-item">
                        <i class="bi bi-info-circle text-primary"></i>
                        <div>
                            <h4>Dicta reprehenderit</h4>
                            <p>Quae dolorem earum veritatis oditseno</p>
                            <p>4 hrs. ago</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="#">Show all notifications</a>
                    </li>
                    </ul>
                </li> -->
                <!-- End Notification Nav -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have 3 new messages
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="message-item">
                        <a href="#">
                            <img src="{{asset('assets/img/messages-1.jpg')}}" alt="" class="rounded-circle">
                            <div>
                                <h4>Maria Hudson</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="message-item">
                        <a href="#">
                            <img src="{{asset('assets/img/messages-2.jpg')}}" alt="" class="rounded-circle">
                            <div>
                                <h4>Anna Nelson</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>6 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="message-item">
                        <a href="#">
                            <img src="{{asset('assets/img/messages-3.jpg')}}" alt="" class="rounded-circle">
                            <div>
                                <h4>David Muldon</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>8 hrs. ago</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="#">Show all messages</a>
                    </li>
                    </ul>
                </li> -->
                <!-- End Messages Nav -->
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->username}}</span>
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
                    @if(Auth::user()->role == 2)
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('admin')}}">
                        <i class="ri-admin-line"></i>
                        <span>Trang Quản Trị</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @endif
                    <!-- <li>
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Need Help?</span>
                        </a>
                    </li> -->
                    <!-- <li>
                        <hr class="dropdown-divider">
                    </li> -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}">
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

    <main style="margin-top:80px;" class="main px-3">

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-0">PHẦN MỀM CHĂM SÓC KHÁCH HÀNG</h5>

            <div class="card pt-3 mb-3">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form class="row g-3">
                        <div class="col-7">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <label for="inputNanme5" class="form-label">Ngày tham gia</label>
                                            <input id="startDate" class="form-control" type="date" value="2019-05-01" />
                                        </div>
                                        <div class="col-4">
                                            <label for="inputNanme4" class="form-label">Ngày Đáo Hạn</label>
                                            <input class="form-control" type="date" value="2020-10-01" />
                                        </div>
                                        <div class="col-4 pe-0">
                                            <label for="inputPassword4" class="form-label">Số Hợp Đồng</label>
                                            <input type="text" class="form-control" id="inputPassword4">
                                        </div>
                                        <div class="col-4">
                                            <label for="inputEmail4" class="form-label">Số Tiền </label>
                                            <input type="number" class="form-control" id="inputEmail4">
                                        </div>
                                        <div class="col-4">
                                            <label for="inputNanme4" class="form-label">Họ Và Tên</label>
                                            <input type="text" class="form-control" id="inputNanme4">
                                        </div>
                                        <div class="col-4 pe-0">
                                            <label for="inputNanme4" class="form-label">Số Điện Thoại</label>
                                            <input type="number" class="form-control" id="inputNanme4">
                                        </div>
                                        <div class="col-2 pe-0">
                                            <label for="inputPassword4" class="form-label">Tuổi</label>
                                            <input type="number" min="1" max="200" onkeyup="if(parseInt(this.value) > 200 || parseInt(this.value) < 1){ this.value = ''; return false; }" class="form-control" id="inputPassword4">
                                        </div>

                                        <div class="col-3">
                                            <label for="inputEmail4" class="form-label">Giới Tính</label>
                                            <select id="inputState" class="form-select">
                                                <option selected="">Chọn giới tính...</option>
                                                <option>Nam</option>
                                                <option>Nữ</option>
                                            </select>
                                        </div>
                                        <div class="col-7 pe-0">
                                            <label for="inputEmail4" class="form-label">Nguồn Dữ Liệu</label>
                                            <select id="inputState" class="form-select">
                                                <option selected="">Chọn nguồn dữ liệu...</option>
                                                <option>Lái Thiêu</option>
                                                <option>Bến Cát</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="inputEmail4" class="form-label">Kết Quả Gọi</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1" checked="">
                                                <label class="form-check-label" for="gridRadios1">
                                                    Đã hẹn
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="2">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Không nghe máy
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="3">
                                                <label class="form-check-label" for="gridRadios3">
                                                    Khách hàng đang suy nghĩ, gọi lại sau.
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios4" value="4">
                                                <label class="form-check-label" for="gridRadios4">
                                                    Khách hàng ít tiền
                                                </label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios5" value="5">
                                                <label class="form-check-label" for="gridRadios5">
                                                Đại lý vẫn chăm sóc
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="col-12">
                                <!-- <textarea class="form-control" placeholder="Ghi chú cụ thể thông tin khách hàng" id="floatingTextarea" rows="5"></textarea> -->
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title pt-3 pb-0">Ghi Chú</h5>

                                            <!-- Quill Editor default -->
                                        <div class="quill-editor-default" style="min-height: 100px;"></div>
                                        <!-- End Quill Editor default -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-danger"><i class="bi bi-exclamation-octagon"></i><span class="ps-2">Reset Dữ liệu</span></button>
                                <button type="button" class="btn btn-success"><i class="bi bi-check-circle"></i><span class="ps-2">Lưu Dữ Liệu</span></button>
                                <button type="button" class="btn btn-outline-primary"><span class="pe-1">Gọi Tiếp Theo</span><i class="bi bi-chevron-double-right"></i>
                            </button>
                            </div>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
            <!-- Default Tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Nhật ký cuộc gọi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Danh sách đã gọi</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabContent">
                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="text-center">Dữ liệu chưa có</h5>
                        <!-- Table with hoverable rows -->
                        <!-- <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Số Điện Thoại</th>
                                    <th scope="col">Ghi Chú</th>
                                    <th scope="col">Kết Quả Cuộc Gọi</th>
                                    <th scope="col">Ngày Gửi</th>
                                    <th scope="col">Ngày Gọi</th>
                                    <th scope="col">Nguồn Dữ Liệu</th>
                                    <th scope="col">Trạng Thái ĐT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Nguyễn Văn Nam</td>
                                    <td>097262212</td>
                                    <td>Khách hàng có ý định muốn mua bảo hiểm. Hiện tại chưa có tiền đủ</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td><span class="badge bg-primary">Primary</span></td>
                                </tr>
                            </tbody>
                        </table> -->
                        <!-- End Table with hoverable rows -->
                    </div>
                </div>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center">Dữ liệu chưa có</h5>
                        <!-- Table with hoverable rows -->
                        <!-- <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Số Điện Thoại</th>
                                    <th scope="col">Ghi Chú</th>
                                    <th scope="col">Kết Quả Cuộc Gọi</th>
                                    <th scope="col">Ngày Gửi</th>
                                    <th scope="col">Ngày Gọi</th>
                                    <th scope="col">Nguồn Dữ Liệu</th>
                                    <th scope="col">Trạng Thái ĐT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Nguyễn Văn Nam</td>
                                    <td>097262212</td>
                                    <td>Khách hàng có ý định muốn mua bảo hiểm. Hiện tại chưa có tiền đủ</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td>2016-05-25</td>
                                    <td><span class="badge bg-primary">Primary</span></td>
                                </tr>
                            </tbody>
                        </table> -->
                        <!-- End Table with hoverable rows -->
                    </div>
                </div>
            </div><!-- End Default Tabs -->
        </div>
        </div>

        <section class="section dashboard">
            <div class="row">

            </div>
        </section>
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
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/vendor/chart.js/chart.min.js')}}"></script>
    <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Jquery Slim JS -->
    <script src="{{ asset('js/jquery.min.js')}} "></script>

    <script src="{{ asset('js/jquery-ui.min.js')}} "></script>

    <svg id="SvgjsSvg1145" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;"><defs id="SvgjsDefs1146"></defs><polyline id="SvgjsPolyline1147" points="0,0"></polyline><path id="SvgjsPath1148" d="M-1 270.2L-1 270.2C-1 270.2 176.9170673076923 270.2 176.9170673076923 270.2C176.9170673076923 270.2 294.86177884615387 270.2 294.86177884615387 270.2C294.86177884615387 270.2 412.80649038461536 270.2 412.80649038461536 270.2C412.80649038461536 270.2 530.7512019230769 270.2 530.7512019230769 270.2C530.7512019230769 270.2 648.6959134615385 270.2 648.6959134615385 270.2C648.6959134615385 270.2 766.640625 270.2 766.640625 270.2C766.640625 270.2 766.640625 270.2 766.640625 270.2 "></path></svg>

    <script src="{{ asset('js/toastr.min.js')}} "></script>

    {!! Toastr::message() !!}

</body>

</html>
