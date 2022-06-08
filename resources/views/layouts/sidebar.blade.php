<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
         <a class="nav-link {{ \Request::route()->getName() !== 'home' ? 'collapsed' : ''}}" href="{{ route('home') }}">
         <i class="bi bi-grid"></i>
         <span>Dashboard</span>
         </a>
      </li>
      <!-- End Dashboard Nav -->
      <li class="nav-item">
         <a class="nav-link {{\Request()->route()->getPrefix() != '/account' ? 'collapsed' : '' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
         <i class="bi bi-people"></i><span>Quản Lý Tài khoản</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="components-nav" class="nav-content collapse {{\Request()->route()->getPrefix() == 'admin/account' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
               <a href="{{route('list_account')}}" class="{{ \Request::route()->getName() == 'list_account' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Danh sách tài khoản</span>
               </a>
            </li>
         </ul>
      </li>
      <!-- End Components Nav -->
      <li class="nav-item">
         <a class="nav-link {{\Request()->route()->getPrefix() != '/customer' ? 'collapsed' : '' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
         <i class="bi bi-person-plus"></i><span>Quản Lý Khách Hàng</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="forms-nav" class="nav-content collapse {{\Request()->route()->getPrefix() == '/customer' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
               <a href="{{route('list_customer')}}" class="{{ \Request::route()->getName() == 'list_customer' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Danh sách khách hàng</span>
               </a>
            </li>
         </ul>
      </li>
      <!-- End Forms Nav -->
      <li class="nav-item">
         <a class="nav-link {{\Request()->route()->getPrefix() != '/excel' ? 'collapsed' : '' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
         <i class="bi bi-file-earmark-excel"></i><span>Dữ liệu Excel</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="tables-nav" class="nav-content collapse {{\Request()->route()->getPrefix() == 'admin/excel' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
               <a href="{{route('data_import')}}" class="{{ \Request::route()->getName() == 'data_import' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Nhập dũ liệu Excel</span>
               </a>
            </li>
            <!-- <li>
               <a href="{{route('data_import_history')}}" class="{{ \Request::route()->getName() == 'data_import_history' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Lịch sử Import</span>
               </a>
            </li> -->
         </ul>
      </li>
      <!-- --------------------- -->
      <li class="nav-item">
         <a class="nav-link {{\Request()->route()->getPrefix() != '/area' ? 'collapsed' : '' }}" data-bs-target="#tables-area" data-bs-toggle="collapse" href="#">
         <i class="bi bi-file-earmark-excel"></i><span>Quản Lý Khu Vực</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="tables-area" class="nav-content collapse {{\Request()->route()->getPrefix() == 'admin/area' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
               <a href="{{route('index_area')}}" class="{{ \Request::route()->getName() == 'index_area' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Danh sách khu vực</span>
               </a>
            </li>
            <li>
               <a href="{{route('customer_by_area')}}" class="{{ \Request::route()->getName() == 'customer_by_area' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Thêm khách hàng vào khu vực</span>
               </a>
            </li>
         </ul>
      </li>
   </ul>
</aside>

<!-- End Sidebar-->
