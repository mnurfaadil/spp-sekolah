@extends('layouts.app')

@section('title')
SPP | Angkatan
@endsection

@section('content')

<div id="edit-form">
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3>Form Ubah Angkatan</h3>
            <hr>
            <div class="sparkline16-graph">
                <div class="date-picker-inner">
                    <div class="basic-login-inner">
                        <form method="post" id="form-angkatan">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Angkatan</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                                    <input type="number" class="form-control" name="angkatan2"
                                        placeholder="Masukan angkatan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tahun Angkatan</label>
                                <div class="input-mark-inner mg-b-22">
                                    <input type="text" class="form-control" name="tahun2" data-mask="9999" placeholder="Masukan tahun angkatan" required>
                                    <span class="help-block">yyyy</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="chosen-select-single mg-b-20">
                                    <select class="form-control" name="status" id="edit-status" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="X">Kelas X</option>
                                        <option value="XI">Kelas XI</option>
                                        <option value="XII">Kelas XII</option>
                                        <option value="ALUMNI">Alumni</option>
                                    </select>
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
            <h3>Form Tambah Angkatan</h3>
            <hr>
            <div class="sparkline16-graph">
                <div class="date-picker-inner">
                    <div class="basic-login-inner">
                        <form action="{{route('angkatan.store')}}" method="post" id="form-angkatan">
                            @csrf
                            <div class="form-group">
                                <label>Angkatan</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                                    <input type="number" class="form-control" name="angkatan" min="1"
                                        placeholder="Masukan angkatan" autofocus required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tahun Angkatan</label>
                                <div class="input-mark-inner mg-b-22">
                                    <input type="text" class="form-control" name="tahun" data-mask="9999" placeholder="Masukan tahun angkatan" required>
                                    <span class="help-block">yyyy</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="chosen-select-single mg-b-20">
                                    <select class="form-control" name="status"  required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="X">Kelas X</option>
                                        <option value="XI">Kelas XI</option>
                                        <option value="XII">Kelas XII</option>
                                        <option value="ALUMNI">Alumni</option>
                                    </select>
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
                                                <h3>Data angkatan</h3>
                                            </div>
                                            <div class="col-md-6">
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
                                        <select class="form-control dt-tb">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true"
                                        data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                        data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th data-field="id">No</th>
                                                <th data-field="update" data-editable="false">Terakhir Update</th>
                                                <th data-field="angkatan" data-editable="false">Angkatan</th>
                                                <th data-field="tahun" data-editable="false">Tahun Angkatan</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="action" data-editable="false" >
                                                    <div style="text-align:center;">Action</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($angkatan as $data)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$data->updated_at}}</td>
                                                <td>{{$data->angkatan}}</td>
                                                <td>{{$data->tahun}}</td>
                                                <td>
                                                    @if($data->status!="ALUMNI")
                                                    Kelas {{$data->status}}
                                                    @else
                                                    {{$data->status}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="text-align:center;">
                                                        <a href="#" class="btn btn-warning"
                                                            onclick="editConfirm( '{{$data->id}}', '{{$data->angkatan}}','{{$data->tahun}}','{{$data->status}}')"
                                                            title="Edit" style="margin-top:0;"><i
                                                                class="fa fa-edit"></i></a>
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
    function editConfirm(id, nama,tahun,status) {
        $('#add-form').hide();
        $('#edit-form').show();
        $('input[name=id]').attr('value', id);
        $('input[name=angkatan2]').attr('value', nama);
        $('input[name=tahun2]').attr('value', tahun);
        $('#edit-status').val(status);
        $('#form-angkatan').attr('action', "{{ url('angkatan') }}/" + id);
        $('input[name=angkatan]').focus();
    }

    function addConfirm() {
        $('#add-form').show();
        $('#a').attr('value','');
        $('#a').focus();
        $('#edit-form').hide();
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

    <!-- input-mask JS
		============================================ -->
<script src="{{ asset('assets/js/input-mask/jasny-bootstrap.min.js') }}"></script>
@endpush

@push('breadcrumb-left')
<h2>Menu angkatan</h2>
@endpush
@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">angkatan</li>
        </ol>
    </nav>
</div>
@endpush
