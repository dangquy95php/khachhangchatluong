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
         <ul id="components-nav" class="nav-content collapse {{\Request()->route()->getPrefix() == '/account' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
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
         <i class="bi bi-person-plus"></i><span>Khoảng Lý Khách Hàng</span><i class="bi bi-chevron-down ms-auto"></i>
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
         <ul id="tables-nav" class="nav-content collapse {{\Request()->route()->getPrefix() == '/excel' ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
            <li>
               <a href="{{route('data_import')}}" class="{{ \Request::route()->getName() == 'data_import' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Nhập dũ liệu Excel</span>
               </a>
            </li>
            <li>
               <a href="{{route('data_import_history')}}" class="{{ \Request::route()->getName() == 'data_import_history' ? 'active' : ''}}">
               <i class="bi bi-circle"></i><span>Lịch sử Import</span>
               </a>
            </li>
            <li>
               <a href="tables-data.html">
               <i class="bi bi-circle"></i><span>Data Tables</span>
               </a>
            </li>
         </ul>
      </li>
   </ul>
</aside>
<!-- End Sidebar-->