<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'));
});

Breadcrumbs::for('excel', function ($trail) {
    $trail->parent('home');
    $trail->push('Nhập dữ liệu', route('data_import'));
});

Breadcrumbs::for('list_account', function ($trail) {
    $trail->parent('home');
    $trail->push('Tài khoản nhân viên', route('list_account'));
});

Breadcrumbs::for('list_customer', function ($trail) {
    $trail->parent('home');
    $trail->push('Danh sách khách hàng', route('list_customer'));
});

Breadcrumbs::for('data_import', function ($trail) {
    $trail->parent('home');
    $trail->push('Lịc sử import', route('data_import'));
});

Breadcrumbs::for('area', function ($trail) {
    $trail->parent('home');
    $trail->push('Danh sách khu vực', route('index_area'));
});