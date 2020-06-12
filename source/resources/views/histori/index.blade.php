@extends('layouts.app')

@section('title')
SPP | Histori
@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id"><div style="text-align: center">No</div></th>
                                        <th data-field="name"><div style="text-align: center">Nama</div></th>
                                        <th data-field="besaran"><div style="text-align: center">Kelas</div></th>
                                        <th data-field="jenis"><div style="text-align: center">Angkatan</div></th>
                                        <th data-field="total"><div style="text-align: center">Total Pembayaran (Rp.)</div></th>
                                        <th data-field="action"><div style="text-align: center">Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum = 0;
                                @endphp
                                @foreach($students as $student)
                                    @php
                                        $sum += intval($student->total_pembayaran);
                                    @endphp
                                    <tr>
                                        <td><div style="text-align: center">{{$no++}}</div></td>
                                        <td><div style="text-align: center">{{$student->nama}}</div></td>
                                        <td><div style="text-align: center">{{$student->kelas}} - {{$student->inisial}}</div></td>
                                        <td><div style="text-align: center">{{$student->angkatan}} ({{$student->tahun_angkatan}})</div></td>
                                        <td><div style="text-align: right">{{number_format($student->total_pembayaran,0,',','.')}}</div></td>
                                        <td>
                                            <center>
                                                <button class="btn btn-success" 
                                                title="Detail"
                                                onclick="history({{$student}})">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </center>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="container-sm" style="margin-top:10px">
                                        <div class="row">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right; margin-right:20%">
                                                    <div class="row">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Total Pembayaran</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:24px;color:red">
                                                                                <strong>{{ number_format($sum,0,',','.') }}</strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
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
        </div>
    </div>
</div>
<!-- Static Table End -->

<!-- modal history -->
<div class="modal fade bd-example-modal-lg" id="modalHistory" tabindex="-1" role="dialog"
    aria-labelledby="modalHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="title_modal_history">History Pembayaran Hari Ini</h4>
            </div>
            <form action="{{ route('history.store') }}" role="form" method="post">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-3 col-sm-3">
                            Tanggal
                        </div>
                        :
                        <input type="hidden" name="tanggal" id="tanggal_history_hidden">
                        <strong><span id="tanggal_history_modal"></span></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            Nama
                        </div>
                        <input type="hidden" name="nama" id="nama_history_hidden">
                        : <strong><span id="nama_history_modal"></span></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            Kelas
                        </div>
                        <input type="hidden" name="kelas" id="kelas_history_hidden">
                        : <strong><span id="kelas_history_modal"></span></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            Angkatan
                        </div>
                        <input type="hidden" name="angkatan" id="angkatan_history_hidden">
                        : <strong><span id="angkatan_history_modal"></span></strong>
                    </div>
                    <input type="hidden" name="data" id="data_hidden">
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="static-table-list">
                                <table class="table" id="table_history">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu Pembayaran</th>
                                            <th>Deskripsi</th>
                                            <th>Nominal (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">
                                                <div style="text-align: center; font-size: 16pt">Jumlah</div>
                                            </th>
                                            <th>
                                                <div style="text-align: right; font-size: 16pt" id="total_history">0</div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" 
                    onclick="$('#table_history tbody tr').remove();">Close</button>
                    <button type="submit" class="btn btn-primary">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

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

<!-- icheck JS
    ============================================ -->
<script src="{{ asset('assets/js/icheck/icheck.min.js')}}"></script>
<script src="{{ asset('assets/js/icheck/icheck-active.js')}}"></script>

<script>
function getRupiah(nominal)
{
    var	number_string = nominal.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
            
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    return rupiah;
}
function getTanggal(tanggal)
{
    var currentDate = new Date(tanggal);

    var date = currentDate.getDate();
    var month = currentDate.getMonth(); //Be careful! January is 0 not 1
    var year = currentDate.getFullYear();

    return date + "/" +(month + 1) + "/" + year;
}
function getTanggalWaktu(tanggal)
{
    var currentDate = new Date(tanggal);

    return currentDate.toLocaleString();
}
function history(murid){
    var dateString = getTanggal(murid.created_at);
    
    $('#tanggal_history_modal').html(dateString);
    $('#nama_history_modal').html(murid.nama);
    $('#kelas_history_modal').html(`${murid.kelas} - ${murid.jurusan}`);
    $('#angkatan_history_modal').html(`${murid.angkatan} (${murid.tahun_angkatan})`);
    
    $('#tanggal_history_hidden').attr("value",dateString);
    $('#nama_history_hidden').attr("value",murid.nama);
    $('#kelas_history_hidden').attr("value",`${murid.kelas} - ${murid.jurusan}`);
    $('#angkatan_history_hidden').attr("value",`${murid.angkatan} (${murid.tahun_angkatan})`);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "{{url('')}}/history/" + murid.id,
        success: function (response) {
            var data = [];
            var sum = 0;
            $.each(response, function(i, item) {
                var tanggal = getTanggalWaktu(item.created_at);
                var rupiah = getRupiah(item.nominal);
                sum += parseInt(item.nominal);
                var temp = [(i+1), tanggal, item.title, rupiah];
                data.push(temp);
                var $tr = 
                $('<tr>').append(
                    $('<td>').text(i+1),
                    $('<td>').text(tanggal),
                    $('<td>').text(item.title),
                    $('<td>').append(
                        `<div style="text-align: right;">${rupiah}</div>`
                    )
                ).appendTo('#table_history');
            });
            
            $('input[type=hidden][name=data]').val(murid.id);
            var rupiah = getRupiah(sum);
            $('#total_history').html(`${rupiah}`);
        },
        error: function (error) {
            alert(error);
        }
    });
    $('#modalHistory').modal();
}
</script>
@endpush

@push('breadcrumb-left')
<h3>Data Histori</h3>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Histori</li>
        </ol>
    </nav>
</div>
@endpush