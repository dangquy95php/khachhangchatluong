@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>QUẢNG LÝ KHÁCH HÀNG THEO TỪNG KHU VỰC</h1>

    {{ Breadcrumbs::render('customer_by_area') }}

@endsection

@section('content')

<section class="section">

    <div class="card mb-3">
        <div class="card-body">
        <h5 class="card-title">Quản Lý Khách Hàng Theo Từng Vực</h5>
        <form class="row g-3">
            <div class="col-4">
                <label for="inputNanme4" class="form-label">Khu Vực:</label>
                <select id="inputState" class="form-select">
                    <option selected="">Chọn khu vực...</option>
                    @foreach($areas as $area)
                        <option value="{{$area->id}}">{{$area->name}}</option>
                    @endforeach
                </select>
            </div>
        </form>
        </div>
    </div>
</section>

@endsection
