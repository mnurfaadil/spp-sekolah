@extends('layouts.app')

@section('title')
SPP | Pembayaran Bulanan
@endsection

@section('content')
@php
$bulan = ['',"Januari", "Februari", "Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
@endphp


<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">

    <div class="hpanel hblue sparkline16-list responsive-mg-b-30">
        <div class="panel-body custom-panel-jw">
            <h3>Data Diri Siswa</h3>
            <hr>

            <div class="sparkline16-graph">
                <div class="date-picker-inner">

                    <div class="basic-login-inner">
                        
                            <div class="form-group">
                                <label>NIS</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-id-card-o"></i></span>
                                    <input type="text" class="form-control" name="nis" value="{{$payment_details[0]->payment->student->nis}}" readonly disable>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                    <input type="text"class="form-control" name="nama" value="{{$payment_details[0]->payment->student->nama}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-mortar-board  "></i></span>
                                    <input type="text" min="0" class="form-control" value="{{$payment_details[0]->payment->student->kelas}} - {{$payment_details[0]->payment->student->major->nama}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Angkatan</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bookmark  "></i></span>
                                    <input type="text" class="form-control" name="angkatan" value="Angkatan ke - {{$payment_details[0]->payment->student->angkatans->angkatan}} ({{$payment_details[0]->payment->student->angkatans->tahun}})"readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Simpanan</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                    <input type="text" class="form-control" name="angkatan" value="{{number_format($payment_details[0]->payment->student->simpanan?$payment_details[0]->payment->student->simpanan:'0',0,',','.')}}"readonly>
                                </div>
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
                                            
                                        </div>
                                        <div class="col-md-6"> 
                                            <div style="float:right;">
                                                <a href="{{ route('pdf.print.bulanan',[$payment_details[0]->payment->student->id,$payment_details[0]->payment->id,$payment_details[0]->payment->category->id]) }}"
                                                    style="color:white; margin-top:0" class=" btn btn-success" target="_blank"><i
                                                        class="fa fa-print"></i>&nbsp; Cetak</a>
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
                                                <th data-field="id">
                                                    <div style="text-align: center">
                                                    No
                                                    </div>
                                                </th>
                                                <th data-field="tanggal">
                                                    <div style="text-align: center">
                                                    Tanggal Pembayaran
                                                    </div>
                                                </th>
                                                <th data-field="periode">
                                                    <div style="text-align: center">
                                                    Bulan
                                                    </div>
                                                </th>
                                                <th data-field="nominal">
                                                    <div style="text-align: center">
                                                    Nominal
                                                    </div>
                                                </th>
                                                <th data-field="total">
                                                    <div style="text-align: center">
                                                    Penerima
                                                    </div>
                                                </th>
                                                <th data-field="action">
                                                    <div style="text-align: center">
                                                    Action
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total= $payment_details->count()*intval($payment_details[0]->periode->nominal);
                                            $terbayar = intval($payment_details->sum('nominal'));
                                            $sisa = $total-$terbayar;
                                            @endphp
                                            @foreach($payment_details as $data)
                                                @php
                                                    $temp = explode("-",$data->bulan);
                                                    $data->bulan = $temp[2]."/".$temp[1]."/".$temp[0];
                                                @endphp
                                            <tr>
                                                <td>
                                                    <div style="text-align: center">
                                                    {{$no++}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center">
                                                    @if($data->status=="Lunas")
                                                        @php
                                                            $temp = explode("-",$data->tgl_dibayar);
                                                            $data->tgl_dibayar = $temp[2]."/".$temp[1]."/".$temp[0];
                                                        @endphp
                                                    {{$data->tgl_dibayar}}
                                                    @elseif($data->status=="Waiting")
                                                    <span class="badge" style="background-color:yellow;color:black">Waiting</span>
                                                    @else
                                                    <span class="badge" style="background-color:red;color:white">Nunggak</span>
                                                    @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: right">
                                                    {{$data->bulan}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: right">
                                                    {{number_format($data->nominal?$data->nominal:"0",0,',','.')}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center">
                                                    @if($data->status=="Lunas")
                                                    {{$data->user->name}}
                                                    @elseif($data->status=="Waiting")
                                                    <span class="badge" style="background-color:yellow;color:black">Waiting</span>
                                                    @else
                                                    <span class="badge" style="background-color:red;color:white">Nunggak</span>
                                                    @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="text-align: center">
                                                    @if($data->status="Lunas" && $data->tgl_dibayar)
                                                    <a href="{{ route('pdf.print.bulanan.detail',[$payment_details->first()->payment->student->id, $data->id])}}" class="btn btn-success" style="color:white;margin-top:0" target="_blank"><i class="fa fa-print"></i></a>
                                                    <a href="{{ route('payment.monthly.detail.delete',$data->id) }}" class="btn btn-danger" style="color:white;margin-top:0" title="Delete"><i class="fa fa-close"></i></a>
                                                    @else
                                                      <button class="btn btn-primary" title="Atur Pembayaran" onclick="addConfirm({{$data}})"><i class="fa fa-credit-card"></i></button>
                                                    @endif
                                                    </div>
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
                                                                    <td>Total</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:18px;">
                                                                                <strong>{{number_format($total,0,',','.')}}</strong></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Telah dibayar</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td style="border-bottom: 1px solid #000;">
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:18px;">
                                                                                <strong>{{number_format($terbayar,0,',','.')}}</strong></span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tunggakan</td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            @if($sisa!=0)
                                                                            <span class="" style="font-size:24px;color:red">
                                                                            @else
                                                                            <span class="" style="font-size:24px;color:green">
                                                                            @endif
                                                                                <strong>{{number_format($sisa,0,',','.')}}</strong>
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
    </div>
</div>
<!-- Static Table End -->
<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalAddLabel">Pilih Metode Pembayaran Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('payment.monthly.detail.update') }}" role="form" method="post" id="form-bayar">
                @method('PUT')
                {{csrf_field()}}
                <input type="hidden" name="payment_id" value="{{$payment_details[0]->payment_id}}">
                <input type="hidden" name="student_id" value="{{$payment_details[0]->payment->student->id}}">
                <input type="hidden" name="category_id" value="{{$payment_details[0]->payment->category->id}}">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="periode" value="">
                <input type="hidden" name="set_simpanan" value="0">
                <input type="hidden" name="nominal_bayar" value="{{$payment_details[0]->periode->nominal}}">
                <input type="hidden" name="penerima" value="">
                
                <div class="form-group">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-3">
                        Kategori Pembiayaan
                    </div>
                    :
                    <strong><span id="kategori_history_modal">{{$financing->nama}}</span></strong>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Periode
                    </div>
                    : <strong><span id="periode_modal"></span></strong>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Besaran Pembiayaan
                    </div>
                    : <strong>Rp. <span id="besaran_history_modal">{{number_format($payment_details[0]->periode->nominal,0,',','.')}}</span></strong>
                </div>
                <hr>
                    <label class="control-label col-md-4">Status Pembayaran<kode>*</kode></label>
                    <div class="chosen-select-single mg-b-20">
                        <select class="chosen-select" name="status">
                            <option value="Lunas">Lunas</option>
                            <option value="Waiting">Waiting</option>
                            <option value="Nunggak">Nunggak</option>
                        </select>
                    </div>
                </div>
                <div id="form">
                            <div class="form-group data-custon-pick" id="data_2">
                                <label>Tanggal Pembayaran<kode>*</kode></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" required placeholder="Tanggal Pembayaran" name="calendar">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Gunakan Simpanan Siswa ?</label>
                                <div class="chosen-select-single mg-b-20">
                                    <select class="form-control" name="gunakan_simpanan"  required>
                                        <option value="0">Tidak</option>
                                        <option value="1">Gunakan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Uang Tunai</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" min="0" class="form-control" name="uang"
                                        placeholder="Masukan nominal">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Simpanan Siswa</label>
                                <input type="hidden" name="simpanan" value="{{intval($payment_details[0]->payment->student->simpanan?$payment_details[0]->payment->student->simpanan:'0')}}">
                                <div class="input-group date">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" min="0" class="form-control" name="simpanan_show"
                                        value="{{number_format($payment_details[0]->payment->student->simpanan?$payment_details[0]->payment->student->simpanan:'0',0,',','.')}}" title="Simpanan siswa" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nominal Bayar</label>
                                <div class="input-group date">
                                    <span class="input-group-addon">Rp.</span>
                                    <input type="number" min="0" class="form-control" name="nominal" value="0" readonly>
                                </div>
                            </div>

                            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type='button' class="btn btn-primary" id="btn-form-bayar"><i class="fa fa-floppy-o"></i> Submit</button>
                </form>
            </div>
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
<script>
    $(document).ready(function () {
        $('#btn-form-bayar').on('click', function () {
            event.preventDefault();
            swal({
                title: 'Apakah anda yakin?',
                text: 'Konfirmasi status pembayaran!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function (value) {
                if (value) {
                    let form = $('#form-bayar').serializeArray();
                    if (form[5].value>0) {
                        document.getElementById('form-bayar').submit();
                    } else {
                        swal({
                            text: 'Nominal Kosong! Transaksi dibatalkan',
                            icon: 'warning',
                            buttons: ["Yes!"],
                        });
                    }
                } else {
                    swal("Transaksi di batalkan!");
                }
            });
        });
    });

</script>
<!-- chosen JS
    ============================================ -->
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
<script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script>

<script>
    function addConfirm(data){
        $('input[name=id]').attr('value',data.id);
        $('input[name=periode]').attr('value',data.bulan);
        $('#periode_modal').html(data.bulan);
        event.preventDefault();
        $('#modalAdd').modal();
    }
    function addPeriode() {
        event.preventDefault();
        $('#modalPeriode').modal();
    }
</script>
<script>

$('select[name=status]').change(function(){
    var cek = $('select[name=status]').val();
    if(cek=="Lunas"){
        $('input[name=tanggal_bayar]').attr('required', true);
        $('input[name=nominal_bayar]').attr('required', true);
        $('#form').show();
    }else{
        $('input[name=tanggal_bayar]').attr('required', false);
        $('input[name=nominal_bayar]').attr('required', false);
        $('#form').hide();
    }
});
    $(document).ready(function () {
        var simpanan = parseInt($('input[name=simpanan]').val());
        var tunai = parseInt($('input[name=uang]').val());
        tunai =(Number.isNaN(tunai))?0:tunai;
        if($('select[name=gunakan_simpanan]').val()==1){
            var nominal = simpanan + tunai;
        }else{
            var nominal = tunai;
        }
        $('input[name=nominal]').val(nominal);

        $('#btn-form-bayar').on('click', function () {
            event.preventDefault();
            swal({
                title: 'Apakah anda yakin?',
                text: 'Data yang sudah dimasukan tidak dapat diubah!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function (value) {
                if (value) {
                    let form = $('#form-bayar').serializeArray();
                    if(form[10].value=="Lunas"){
                      if (parseInt(form[16].value) > 0) {
                          if(parseInt(form[16].value) > parseInt(form[8].value)){
                              swal({
                                  title : 'Konfirmasi',
                                  text : 'Uang bayar lebih, masuk simpanan siswa ?',
                                  icon : 'warning',
                                  buttons : ['Tidak', 'Ya!'],
                              }).then(function(value){
                                  if(value){
                                      $('input[name=set_simpanan]').val(1);
                                  }else{
                                      $('input[name=set_simpanan]').val(0);
                                  }
                                  document.getElementById('form-bayar').submit();
                                });
                            }else if(parseInt(form[16].value) == parseInt(form[8].value)){
                                document.getElementById('form-bayar').submit();
                          }else{
                            swal("Uang kurang, transaksi di batalkan!");
                          }
                      } else {
                          swal({
                              text: 'Nominal Kosong! Transaksi dibatalkan',
                              icon: 'warning',
                              buttons: ["Yes!"],
                          });
                      }
                    }else{
                      document.getElementById('form-bayar').submit();
                    }
                } else {
                    swal("Transaksi di batalkan!");
                }
            });
        });
    });
    $( "input[name=uang]").keyup(function() {
        var simpanan = parseInt($('input[name=simpanan]').val());
        var tunai = parseInt($('input[name=uang]').val());
        tunai =(Number.isNaN(tunai))?0:tunai;
        if($('select[name=gunakan_simpanan]').val()==1){
            var nominal = simpanan + tunai;
        }else{
            var nominal = tunai;
        }
        $('input[name=nominal]').val(nominal);
    });
    $('select[name=gunakan_simpanan]').change(function(){
        var simpanan = parseInt($('input[name=simpanan]').val());
        var tunai = parseInt($('input[name=uang]').val());
        tunai =(Number.isNaN(tunai))?0:tunai;
        if($('select[name=gunakan_simpanan]').val()==1){
            var nominal = simpanan + tunai;
        }else{
            var nominal = tunai;
        }
        $('input[name=nominal]').val(nominal);
    });
</script>
@endpush

@push('breadcrumb-left')
<div class="col-md-1" style="item-align:center">
<a class="btn btn-primary" href="{{ route('payment.show',$financing->id)}}" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
</div>
<div class="col-md-11">
    <div style="margin-left:15px;">
    <h4>Pembayaran {{$financing->nama}}</h4>
    <span class="all-pro-ad">Kategori Pembayaran : <strong>{{$financing->jenis}}</strong></span>
    </div>
</div>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/payment')}}">Pembayaran</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payment.show',$financing->id)}}">{{$financing->nama}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
</div>
@endpush
