<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Ký Tài Khoản Nhân Viên</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1170/1170576.png">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">

      <!-- Template Main CSS File -->
      <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

<main>
   <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                  <div class="d-flex justify-content-center py-4">
                     <a href="index.html" class="logo d-flex align-items-center w-auto">
                     <img src="{{asset('assets/img/logo.png')}}" alt="">
                     <span class="d-none d-lg-block">Sales KHÁCH HÀNG</span>
                     </a>
                  </div>
                  <!-- End Logo -->
                  <div class="card mb-3">
                     <div class="card-body">
                        <div class="pt-4 pb-2">
                           <h5 class="card-title text-center pb-0 fs-4">Tạo Tài Khoản</h5>
                           <p class="text-center small">Nhập thông tin chi tiết của bạn để tạo tài khoản</p>
                        </div>
                        <form class="row g-3 needs-validation" novalidate>
                           <div class="col-12">
                              <label for="yourName" class="form-label">Tên của bạn</label>
                              <input type="text" name="name" class="form-control" id="yourName" required>
                              <div class="invalid-feedback">Please, enter your name!</div>
                           </div>
                           <div class="col-12">
                              <label for="yourEmail" class="form-label">Email</label>
                              <input type="email" name="email" class="form-control" id="yourEmail" required>
                              <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                           </div>
                           <div class="col-12">
                              <label for="yourUsername" class="form-label">Tên đăng nhập <span class="badge rounded-pill bg-warning text-dark">Viết không dấu</span></label>
                              <div class="input-group has-validation">
                                 <span class="input-group-text" id="inputGroupPrepend">@</span>
                                 <input type="text" name="username" class="form-control" id="yourUsername" required>
                                 <div class="invalid-feedback">Please choose a username.</div>
                              </div>
                           </div>
                           <div class="col-12">
                              <label for="yourPassword" class="form-label">Mật khẩu</label>
                              <input type="password" name="password" class="form-control" id="yourPassword" required>
                              <div class="invalid-feedback">Please enter your password!</div>
                           </div>
                           <div class="col-12 mt-4">
                              <button class="btn btn-primary w-100" type="submit">Đăng Ký</button>
                           </div>
                           <div class="col-12">
                              <p class="small mb-0">Tôi đã có tài khoản? <a href="{{route('login')}}">Đăng Nhập</a></p>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="credits">
                     <!-- All the links in the footer should remain intact. -->
                     <!-- You can delete the links only if you purchased the pro version. -->
                     <!-- Licensing information: https://bootstrapmade.com/license/ -->
                     <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                    Thiết kế bởi <a href="https://pxwebshop.com/">Công Ty TNHH PxwebShop</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
</main>
<!-- End #main -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>