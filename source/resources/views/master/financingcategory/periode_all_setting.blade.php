@extends('layouts.app')

@section('title')
SPP | Kategori Pembayaran
@endsection

@section('content')
<div id="edit-form">
<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3><a href="">Ubah Biaya</a></h3>
            <p class="all-pro-ad">Ubah biaya pembayaran disini</p>
            <hr>

            <div class="sparkline16-graph">
                <div class="date-picker-inner">

                    <div class="basic-login-inner">
                        <form action="" method="post">
                        @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $periodes[0]->id}}">
                            <input type="hidden" name="kategori" value="{{ $periodes[0]->financing_category_id}}">
                            <input type="hidden" name="jurusan" value="{{ $periodes[0]->major_id}}">
                            <div class="form-group">
                                <label class="control-label">Angkatan</label>
                                <input type="hidden" name="angkatan">
                                <div class="input-group">
                                    <span class="input-group-addon"><strong><i class="fa fa-bookmark"></i></strong></span>
                                    <input type="text" name="angkatan_show" id="edit-angkatan" class="form-control" value="Kelas {{ $periodes[0]->angkatan->status}} - Angkatan {{ $periodes[0]->angkatan->angkatan}} ({{ $periodes[0]->angkatan->tahun}})" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Jurusan</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong><i class="fa fa-mortar-board"></i></strong></span>
                                    <input type="text" class="form-control" name="jurusan_show" value="{{ $periodes[0]->major->nama}}" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                    <input type="number" min="0" class="form-control" name="nominal" value="{{ $periodes[0]->nominal}}" id="edit_nominal" required>
                                </div>
                            </div>
                            <div class="login-btn-inner">
                                <div class="inline-remember-me">
                                    <button class="btn btn-sm btn-primary pull-right login-submit-cs"
                                        type="submit">Ubah</button>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="main-sparkline13-hd">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="float:right">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                    <h3>Nominal Pembayaran</h3>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true"
                                        data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                        data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th data-field="id">No</th>
                                                <th data-field="date" data-editable="false">Terakhir Update</th>
                                                <th data-field="jurusan" data-editable="false">Angkatan</th>
                                                <th data-field="nominal" data-editable="false">Nominal</th>
                                                <th data-field="action" data-editable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $no=1;
                                                $bulan=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];                                            
                                            @endphp
                                            @foreach($periodes as $periode)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $periode->updated_at }}</td>
                                                <td>Kelas {{ $periode->angkatan->status }} - Angkatan {{ $periode->angkatan->angkatan }} ({{ $periode->angkatan->tahun }})</td>
                                                <td>
                                                    <div style="text-align:right">
                                                    {{ $periode->nominal }}
                                                    </div>
                                                </td>
                                                <td>
                                                @if($periode->angkatan->status=="ALUMNI")
                                                <div class="alert alert-info" role="alert" style="text-align:center; margin-bottom:0px;padding-top:5px;padding-bottom:5px;">
                                                    <strong>Alumni</strong>
                                                </div>
                                                @else
                                                <div style="text-align:center">
                                                    <button class="btn btn-warning editable"
                                                    title="Edit periode {{$category[0]->nama}}" style="color:white" 
                                                    onclick="editConfirm({{$periode}},'{{ $periode->angkatan->angkatan }} ({{ $periode->angkatan->tahun }})');">
                                                      <i class="fa fa-edit"></i>
                                                    </button>
                                                </div>
                                                @endif
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

<!-- forms CSS
   ============================================ -->
<link rel="stylesheet" href="{{asset('assets/css/form/all-type-forms.css')}}">
<!-- chosen CSS
   ============================================ -->
<link rel="stylesheet" href="{{asset('assets/css/chosen/bootstrap-chosen.css')}}">
@endpush

@push('scripts')
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

    <!-- datapicker JS
		============================================ -->
    <script src="{{asset('assets/js/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('assets/js/datapicker/datepicker-active.js')}}"></script>
    <!-- chosen JS
		============================================ -->
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
    <script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script> 

<script>
    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, data pembayaran pada periode ini akan terhapus!',
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
    function editConfirm(periode, name) {
        console.log(periode);
        $('input[type=hidden][name=id]').val(periode.id);
        $('input[name=angkatan_show]').val('Kelas '+periode.angkatan.status+" - Angkatan "+periode.angkatan.angkatan+" ("+periode.angkatan.tahun+")");
        $('#edit_nominal').attr('value', periode.nominal);
        $('#edit_nominal').focus();
    }
</script>

@endpush


@push('breadcrumb-left')
<a href="{{url('/periode/all',$category[0]->id)}}" style="text-decoration:none">
<button  class="btn btn-primary"> Kembali</button>
</a>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/financing')}}">Pembiayaan</a></li>
            <li class="breadcrumb-item"><a href="{{url('/periode/all',$category[0]->id)}}">{{ $category[0]->nama }}</a></li>
            <li class="breadcrumb-item active">{{ $periodes[0]->major->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">Setting</li>
        </ol>
    </nav>
</div>
@endpush