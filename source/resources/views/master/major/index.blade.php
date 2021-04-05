@extends('layouts.app')

@section('title')
SPP | Jurusan
@endsection

@section('content')
<div id="edit-form">
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3>Form Ubah Jurusan</h3>
            <hr>
            <div class="sparkline16-graph">
                <div class="date-picker-inner">
                    <div class="basic-login-inner">
                        <form method="post" id="form-jurusan">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label>Nama Jurusan</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                                    <input type="text" class="form-control" name="jurusan"
                                        placeholder="Masukan Nama Jurusan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Alias</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-anchor"></i></span>
                                    <input type="text" class="form-control" name="alias"
                                        placeholder="Masukan Nama Alias">
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="inline-remember-me">
                                    <input type="submit" value="Submit"
                                        class="btn btn-sm btn-primary pull-right login-submit-cs">
                                    <label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="add-form">
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3>Form Tambah Jurusan</h3>
            <hr>
            <div class="sparkline16-graph">
                <div class="date-picker-inner">
                    <div class="basic-login-inner">
                        <form action="{{route('majors.store')}}" method="post" id="form-jurusan-add">
                            @csrf

                            <div class="form-group">
                                <label>Nama Jurusan</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                                    <input type="text" class="form-control" name="jurusan" id="a"
                                        placeholder="Masukan Nama Jurusan">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Nama Alias</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-anchor"></i></span>
                                    <input type="text" class="form-control" name="alias"
                                        placeholder="Masukan Nama Alias">
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="inline-remember-me">
                                    <input type="submit" value="Submit"
                                        class="btn btn-sm btn-primary pull-right login-submit-cs">
                                    <label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-lg-8 col-md-6 col-sm-6 col-xs-12">
    <div class="hpanel hblue contact-panel contact-panel-cs responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="container-sm">
                                    <div class="main-sparkline13-hd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3>Data Jurusan</h3>
                                            </div>
                                            <div class="col-md-6" >
                                            <div style="float:right">
                                            <button class="btn btn-success" onclick="addConfirm()">
                                                <i class="fa fa-plus" ></i> Tambah
                                            </button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true"
                                        data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                        data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th data-field="id">No</th>
                                                <th data-field="jurusan" data-editable="false">Nama Jurusan</th>
                                                <th data-field="alias" data-editable="false">Nama Alias</th>
                                                <th data-field="action" data-editable="false">
                                                    <div style="text-align:center;">Action</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($majors as $data)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$data->nama}}</td>
                                                <td>{{$data->inisial}}</td>
                                                <td>
                                                    <div style="text-align:center;">
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="editConfirm({{$data}})"
                                                            title="Edit" style="margin-top:0;"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <a href="{{ route('majors.destroy',$data) }}"
                                                            class="btn btn-danger"
                                                            onclick="event.preventDefault();destroy('{{ route('majors.destroy',$data) }}');"
                                                            title="Hapus" style="margin-top:0;"><i
                                                                class="fa fa-trash"></i></a> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Static Table End -->

<!-- hapus -->
<form id="destroy-form" method="POST">
    @method('DELETE')
    @csrf
</form>
@endsection

@push('styles')
<!-- x-editor CSS  -->
<link rel="stylesheet" href="{{ asset('assets/css/editor/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/bootstrap-editable.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/x-editor-style.css') }}">
<!-- normalize CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-table.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-editable.css') }}">
@endpush

@push('scripts')

<script>
    $(document).ready(function(){
        $('#add-form').show();
        $('#edit-form').hide();
    });
    

    function editConfirm(data) {
        $('#add-form').hide();
        $('#edit-form').show();
        $('input[name=id]').attr('value', data.id);
        $('input[name=jurusan]').attr('value', data.nama);
        $('input[name=alias]').attr('value', data.inisial);
        $('#form-jurusan').attr('action', "{{ url('majors') }}/" + data.id);
        $('input[name=jurusan]').focus();
    }

    function addConfirm() {
        $('#add-form').show();
        $('#a').attr('value','');
        $('#a').focus();
        $('#edit-form').hide();
    }

    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                document.getElementById('destroy-form').setAttribute('action', action);
                document.getElementById('destroy-form').submit();
            } else {
                swal("Data kamu aman!");
            }
        });
    }

</script>
<!-- data table JS
		============================================ -->
<script src="{{ asset('assets/js/data-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/data-table/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/data-table/data-table-active.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-editable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-editable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-resizable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/colResizable-1.5.source.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-export.js') }}"></script>
<!--  editable JS
		============================================ -->
<script src="{{ asset('assets/js/editable/jquery.mockjax.js') }}"></script>
<script src="{{ asset('assets/js/editable/mock-active.js') }}"></script>
<script src="{{ asset('assets/js/editable/select2.js') }}"></script>
<script src="{{ asset('assets/js/editable/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/editable/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/editable/bootstrap-editable.js') }}"></script>
<script src="{{ asset('assets/js/editable/xediable-active.js') }}"></script>
@endpush

@push('breadcrumb-left')
<h2>Menu Jurusan</h2>
@endpush
@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jurusan</li>
        </ol>
    </nav>
</div>
@endpush
