@section('title', 'Trang chủ')
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
                                <ul class="list-group sortable is-scroll" id="area_area_name">
                                    @php
                                        $a = array();
                                        $b = array();
                                        foreach ($areas as $area) {
                                            array_push($a, $area->id);
                                        }
                                        foreach ($areas_users as $area) {
                                            array_push($b, $area->id_area);
                                        }
                                        $lastAreas = array_diff($a, $b);
                                    @endphp
                                    @foreach ($lastAreas as $lastArea)
                                        @foreach ($areas as $area)
                                            @if($lastArea == $area->id)
                                                <li data-id="{{ $area->id }}"
                                                    class="btn-modify d-flex btn btn-secondary mb-2">{{ $area->name }}
                                                </li>
                                            @else
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <form method="post" action="" id="form-user-to-area">
                            {{ csrf_field() }}
                            <div class="card mb-2">
                                <div class="card-body pe-0">
                                    <h5 class="card-title">Nhân viên cấp quyền khu vực</h5>
                                    <!-- Default Accordion -->
                                    <div class="is-scroll">
                                        @foreach ($users as $user)
                                            <div class="accordion is-item" id="accordionExample{{ $user->id }}">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" data-id_user="{{ $user->id }}" id="headingOne{{ $user->id }}">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne_{{ $user->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseOne_{{ $user->id }}">
                                                            <b> {{ $user->username }}</b>
                                                        </button>
                                                    </h2>

                                                    <div id="collapseOne_{{ $user->id }}"
                                                        class="accordion-collapse collapse" aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample{{ $user->id }}">
                                                        <ul class="pb-4 mb-0 is-body-user accordion-body sortable"
                                                            id_user="{{ $user->id }}">

                                                            @foreach ($areas_users as $area_user)
                                                                @if ($area_user->id_user == $user->id)
                                                                    <li data-id="{{$area_user->id_area}}"
                                                                        class="btn-modify d-flex justify-content-between btn btn-secondary mb-2">
                                                                        {{ $area_user->name }}
                                                                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')"
                                                                            class="btn-close-area bg-danger link-light text-center"
                                                                            style="width: 25px;"
                                                                            href="{{ route('del_area_to_user', ['id' => $area_user->id]) }}">
                                                                            <strong>X</strong>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <a id="btn-submit-user" class="btn btn-primary d-flex justify-content-center">Cấp Quyền</a>
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
            var oldList, newList, item;
            $('.sortable').sortable({
                start: function(event, ui) {
                    item = ui.item;
                    newList = oldList = ui.item.parent().parent();
                },
                stop: function(event, ui) {
                    if (item[0].parentElement.classList.contains('is-body-user')) {
                        // var id_area = item[0].id;
                        // var id_string = newList[0].id;
                        // var id_userArray = id_string.split("_")[1];

                        // var tag_input =
                        //     `<input style="display:none;" value="${id_area}" name="user_area[${id_userArray}][]"/>`
                        // item[0].innerHTML += tag_input;
                    } else {
                        // var textInner = item[0].innerText;
                        // item[0].innerHTML = "";
                        // item[0].innerText = textInner;
                    }
                    // alert("Moved " + item.text() + " from " + oldList.attr('id') + " to " + newList.attr('id'));
                },
                change: function(event, ui) {
                    if (ui.sender) newList = ui.placeholder.parent().parent();
                },
                connectWith: ".sortable"
            }).disableSelection();


            $("#btn-submit-user").click(function() {
                var list = $(".is-item");
                // list.each(function(index) {
                //     $(this).child
                // })

                $("#form-user-to-area .is-item").each(function() {
                    let that = this;
                    var id_user = $($(that).find('.accordion-header').get(0)).data('id_user') ;
                    // group-area-user-id
                    console.log(id_user);
                    $(that).find(".btn-modify").each(function() {
                        var area_id = $($(this).get(0)).data('id');
                        var group_change_id_user_area = $($(this).get(0)).data('group-area-user-id');
                        // if (group_change_id_user_area == undefined) {
                        //     var id_user_move = $(this).closest('.accordion-item').children().data('id_user');
                        //     group_change_id_user_area = id_user_move;
                        // }

                        // <input style="display:none;" value="" name="user_area[1][]">
                        var tag_input =`<input class="d-none" value="${area_id}" name="user_area[${id_user}][]"/>`
                        // var tag_input_change =`<input class="d-none" value="${area_id}" name="user_area[${id_user}][]"/>`
                        $($(this).get(0)).append(tag_input);
                        // $($(this).get(0)).append(tag_input_change);
                    })
                });

                $("#form-user-to-area").submit();
            })
        });
    </script>
@endpush

@push('css')
@endpush
