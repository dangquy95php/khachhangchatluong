@section('title','Trang chủ')
@extends('layouts.template')

@section('breadcrumb')

   <h1>DANH SÁCH KHU VỰC</h1>

    {{ Breadcrumbs::render('area') }}

@endsection

@section('content')

<section class="section" id="area-to-user">

   <div class="row">
        <div class="col-12">

            <div class="row">
                <div class="col-sm-6">
                    <div class="card mb-2 full-height">
                        <div class="card-body">
                            <h5 class="card-title pb-0">Tên khu vực cần cấp quyền</h5>
                            <hr />
                            <ul class="list-group sortable" id="area_area_name">
                                @foreach($areas as $area)
                                    <li id_area ="{{ $area->id }}" class="btn-modify d-flex btn btn-secondary mb-2">{{ $area->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <form method="post" action="" id="form-user-to-area">
                        {{ csrf_field() }}
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5 class="card-title">Nhân viên cấp quyền khu vực</h5>
                                <!-- Default Accordion -->
                                @foreach($users as $user)
                                    <div class="accordion" id="accordionExample{{$user->id}}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne{{$user->id}}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{$user->id}}" aria-expanded="false" aria-controls="collapseOne{{$user->id}}">
                                               <b> {{$user->username}}</b>
                                                </button>
                                            </h2>

                                            <div id="collapseOne{{$user->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample{{$user->id}}">
                                                <ul class="pb-4 mb-0 accordion-body sortable" id="area_username{{$user->id}}">

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <a href="#" id="btn-submit-user" class="btn btn-primary d-flex justify-content-center">Save</a>
                    </form>
                </div>
            </div>
        </div>
   </div>
</section>
@endsection

@push('scripts')
<script>
    $(function() {
        $("#area_area_name, #area_username4").sortable({
            connectWith: '.connectedSortable'
        }).disableSelection();
    });


    $(function() {
    var oldList, newList, item;
    $('.sortable').sortable({
        start: function(event, ui) {
            item = ui.item;
            newList = oldList = ui.item.parent().parent();
        },
        stop: function(event, ui) {
            // alert("Moved " + item.text() + " from " + oldList.attr('id') + " to " + newList.attr('id'));
        },
        change: function(event, ui) {
            if(ui.sender) newList = ui.placeholder.parent().parent();
        },
        connectWith: ".sortable"
    }).disableSelection();
});

</script>

<script>


$( "#btn-submit-user" ).click(function() {

    var listArea = [];
    $(".accordion").each(function(index) {
        var username = $(this).find('.accordion-header').text().trim();
        var area = {};

        var listAreaEl = $(this).find('.drop-item');

        $(listAreaEl).each(function(i) {
            let that = this;
            area.id_area = $(that).find('a').attr('id');
            area.name_area = $(that).find('a').text().trim();

            listArea.push(JSON.stringify(area));
        });
    });
console.log(listArea);
    var input = $("<input>").attr("type", "hidden").attr("name", "area_user_data").val(listArea);
    $('#form-user-to-area').append(input);

    // $( "#form-user-to-area" ).submit();
});



</script>

@endpush

@push('css')

@endpush
