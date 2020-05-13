@extends('layouts.app')

@section('title')
SPP | Pembayaran {{$financing->nama}}
@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <div class="container-sm">
                                <div class="row">
                                    <div class="col-md-6">
                                    <form action="{{route('payment.filter')}}" role="form" method="post">
                                        @csrf
                                            <input type="hidden" name="id_kategori" value="{{$financing->id}}">
                                            <div style="float:left; display:flex; flex-direction:row; max-height:55">
                                            <select class="form-control" name="kelas" required>
                                                <option value="">-- Pilih Kelas -- </option>
                                                <option value="all">Semua</option>
                                                <option @if("X"==$kls) selected @endif value="X">X</option>
                                                <option @if("XI"==$kls) selected @endif value="XI">XI</option>
                                                <option @if("XII"==$kls) selected @endif value="XII">XII</option>
                                                </select>

                                                <select style="margin-left:5px;" class="form-control" name="jurusan" required>
                                                <option value="">-- Pilih Jurusan --</option>
                                                <option value="all">Semua</option>
                                                    @if(isset($majors))
                                                        @foreach($majors as $d)
                                                        <option @if($fil==$d->major->id) selected @endif value="{{$d->major->id}}">{{$d->major->nama}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <select style="margin-left:5px;" class="form-control" name="angkatan" required>
                                                <option value="">-- Pilih Angkatan --</option>
                                                <option value="all">Semua</option>
                                                    @if(isset($angkatan))
                                                        @foreach($angkatan as $d)
                                                        <option @if($fil2==$d->angkatan->id) selected @endif value="{{$d->angkatan->id}}">{{$d->angkatan->angkatan}} - {{$d->angkatan->tahun}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <button type='submit' class="btn btn-info" style="margin-left:5px;">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="float:right; margin-right:15px">
                                        <form target="_blank" action="{{route('pdf.print.rekap.sesekali')}}" role="form" method="post">
                                                @csrf 
                                                <input type="hidden" name='id_jur' value="{{$fil}}">
                                                <input type="hidden" name='akt' value="{{$fil2}}">
                                                <input type="hidden" name='kls' value="{{$kls}}">
                                                <input type="hidden" name='nama' value="{{$financing->nama}}">
                                                <input type="hidden" name='id' value="{{$financing->id}}">
                                                <button title="Cetak rekapitulasi {{$financing->nama}}" type='submit' class="btn btn-info" style="color:white; margin-top:0"><i class="fa fa-print"></i>&nbsp; Cetak</button>
                                            </form>
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
                                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id">No</th>
                                        <th data-field="name">Nama</th>
                                        <th data-field="kelas">Kelas</th>
                                        <th data-field="total">Akumulasi Biaya</th>
                                        <th data-field="persentase">Persentase Potongan</th>
                                        <th data-field="potongan">Nominal Potongan</th>
                                        <th data-field="terbayar">Sudah dibayar</th>
                                        <th data-field="tunggakan">Sisa Pembayaran</th>
                                        @if($financing->jenis=="Sekali Bayar")
                                        <th data-field="metode">Metode Pembayaran</th>
                                        @else
                                        <th data-field="banyak">Tunggakan</th>
                                        @endif
                                        <th data-field="status">Status</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                    @php
                                    $akumulasi = number_format($data->periode[0]->nominal,0,',','.');
                                    $piece = $payment_details->where('payment_id', $data->id);
                                    $terbayar = 0;
                                    $i = '';
                                    $j='';
                                    foreach($piece as $p){
                                        $i=$p;
                                    }
                                    $piece_cicilan = $cicilans->where('payment_detail_id', $i->id);
                                    foreach($piece_cicilan as $p){
                                        $terbayar += $p->nominal;
                                    }
                                    $besaran = intval($data->periode[0]->nominal);
                                    $potongan = floor($besaran*$data->persentase/100);
                                    $sisa = $besaran - $potongan - $terbayar;
                                    @endphp
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$data->student->nama}}</td>
                                        <td>{{$data->student->kelas}} - {{$data->student->major->inisial}}</td>
                                        <td>
                                            <div style="text-align:right">
                                                {{$akumulasi}}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                {{$data->persentase}} %
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                {{number_format($potongan,0,',','.')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                {{number_format($terbayar,0,',','.')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:right">
                                                {{number_format($sisa,0,',','.')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center">
                                                @if($data->jenis_pembayaran=="Waiting")
                                                <span class="badge"
                                                    style="background-color:yellow;color:black">Waiting</span>
                                                    @else
                                                {{$data->jenis_pembayaran}}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center">
                                                @if($data->jenis_pembayaran=="Waiting")
                                                <span class="badge"
                                                    style="background-color:yellow;color:black">Waiting</span>
                                                @elseif($data->jenis_pembayaran=="Nunggak")
                                                <span class="badge" style="background-color:red">Nunggak</span>
                                                @elseif($data->jenis_pembayaran=="Cicilan" && $sisa!=0)
                                                <span class="badge" style="background-color:yellow;color:black">Belum
                                                    Lunas</span>
                                                @else
                                                <span class="badge" style="background-color:green">Lunas</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align:center">
                                                @if($data->jenis_pembayaran=="Waiting" || $data->jenis_pembayaran=="Nunggak")
                                                <button class="btn btn-warning"
                                                    onclick="addConfirm({{$data}},'{{$akumulasi}}')"
                                                    title="Pilih Metode Pembayaran" style="color:black;  ">
                                                    <i class="fa fa-info-circle"> Metode</i>
                                                </button>
                                                @elseif($data->jenis_pembayaran=="Cicilan")
                                                <a href="{{ route('payment.details.cicilan', [$financing->id, $data->student->id, $data->id]) }}"
                                                    class="btn btn-primary" title="Cetak Bukti Pembayaran"
                                                    style="color:white;"><i class="fa fa-eye"> Rincian</i></a>
                                                @else
                                                <a href="{{ route('pdf.print.sesekali.detail',[$data->student->id,$data->detail[1]->id, 'tunai'])}}"
                                                    class=" btn btn-success" target="_blank" title="Cetak kwitansi">
                                                    <i class="fa fa-print"></i>&nbsp;Cetak</a>
                                                @endif
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
                <h5 class="modal-title" id="modalAddLabel">Pilih Metode Pembayaran</h5>
            </div>
            <div class="modal-body">
                <div class="basic-login-form-ad">
                    <form action="{{ route('payment.storeMethod') }}" role="form" method="post" id="store">
                        {{csrf_field()}}
                        <input type="hidden" name="payment_id">
                        <input type="hidden" name="financing_category_id" value="{{$financing->id}}">
                        <input type="hidden" name="financing_category" value="{{$financing->nama}}">
                        <input type="hidden" name="nominal" value="{{$financing->besaran}}">
                        <input type="hidden" name="student_id" id="student_id_add" value="">
                        <input type="hidden" name="penerima" value="{{ Auth::user()->nama }}">
                        <div class="row mb-3">
                            <div class="col-md-3 col-sm-3">
                                Pembiayaan
                            </div>
                            :
                            <strong><span>{{$financing->nama}}</span></strong>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                Nominal Pembayaran
                            </div>
                            : <strong>Rp. <span id="nominal_show"></span></strong>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-md-4">Persentase Potongan Biaya (%)<kode>*</kode></label>
                            <input name='persentase' id='persentase_add' placeholder="Masukan persentase potongan biaya" type='number'
                                    min="0" max="100" class='form-control' value="0" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Metode Pembayaran<kode>*</kode></label>
                            <div class="chosen-select-single mg-b-20">
                                <select class="chosen-select" name="metode_pembayaran" id="metode_pembayaran_add" autofocus>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Cicilan">Cicilan</option>
                                    <option value="Nunggak">Nunggak</option>
                                </select>
                            </div>
                            </div>
                        <div id="tanggal">
                            <input type="hidden" name="set_simpanan" value="0">
                            <div class="form-group data-custon-pick" id="data_3">
                                <label><strong>Tanggal Pembayaran</strong></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" name="tanggal_bayar" id="tanggal_bayar_add" value="" placeholder="Masukan tanggal pembayaran">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nominal Pembayaran</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                    <input type="number" min="0" class="form-control" name="nominal_bayar" id="nominal_bayar_add" value="" placeholder="Masukan Nominal pembayaran">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" onclick="confirm()"><i class="fa fa-floppy-o"></i> Submit</button>
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

<!-- datapicker CSS
============================================ -->
<link rel="stylesheet" href="{{asset('assets/css/datapicker/datepicker3.css')}}">

<style>
    kode {
        color: red;
    }

</style>
@endpush

@push('scripts')

<script>
    function closeModal() {
        $('.button_add').bind('click');
    }

    function addConfirm(data, nominal) {
        $('input[name=payment_id]').attr('value', data.id);
        $('input[name=student_id]').attr('value', data.student.id);
        $('input[name=financing_category_id]').attr('value', data.financing_category_id);
        $('input[name=nominal]').attr('value', data.periode[0].nominal);
        $('#nominal_show').html(nominal);
        $('#modalAdd').modal();
    }

    $(document).ready(function(){
        var cek = $('select[name=metode_pembayaran]').val();
        if(cek=="Tunai"){
            $('input[name=tanggal_bayar]').attr('required', true);
            $('input[name=nominal_bayar]').attr('required', true);
            $('#tanggal').show();
        }else{
            $('input[name=tanggal_bayar]').attr('required', false);
            $('input[name=nominal_bayar]').attr('required', false);
            $('#tanggal').hide();
        }
    });

    $('select[name=metode_pembayaran]').change(function(){
        var cek = $('select[name=metode_pembayaran]').val();
        if(cek=="Tunai"){
            $('input[name=tanggal_bayar]').attr('required', true);
            $('input[name=nominal_bayar]').attr('required', true);
            $('#tanggal').show();
        }else{
            $('input[name=tanggal_bayar]').attr('required', false);
            $('input[name=nominal_bayar]').attr('required', false);
            $('#tanggal').hide();
        }
    });

    function confirm() {
        event.preventDefault();
        swal({
            title: 'Apakah anda yakin?',
            text: 'Akan mengkonfirmasi pembayaran ini ?',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                var metode = $('input[name=metode_pembayaran]').val();
                if(metode=="Tunai") {
                    var form = $('#store').serializeArray();
                    if(form[10].value==""){
                        swal("Tanggal pembayaran kosong!");
                        bind();
                        return false;
                    }
                    if(form[11].value==""){
                        swal("Uang pembayaran kosong!");
                        bind();
                        return false;
                    }
                    if(parseInt(form[4].value) > parseInt(form[11].value)){
                        swal("Uang pembayaran kurang!");
                        bind(); 
                        return false;
                    }
                    if(parseInt(form[4].value) < parseInt(form[11].value)){
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
                            document.getElementById('store').submit();
                        });
                    }
                }else{
                    document.getElementById('store').submit();
                }
            } else {
                swal("Pembayaran dibatalkan!");
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

<!-- icheck JS
============================================ -->
<script src="{{ asset('assets/js/icheck/icheck.min.js')}}"></script>
<script src="{{ asset('assets/js/icheck/icheck-active.js')}}"></script>

<!-- chosen JS
============================================ -->
<script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
<script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script>
<!-- datapicker JS
		============================================ -->
<script src="{{asset('assets/js/datapicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/js/datapicker/datepicker-active.js')}}"></script>

<!-- input-mask JS
============================================ -->
<script src="{{ asset('assets/js/input-mask/jasny-bootstrap.min.js')}}"></script>
@endpush

@push('breadcrumb-left')
<div class="col-md-1" style="item-align:center">
    <a href="{{ url('/payment')}}" class="btn btn-primary" href="#" title="Kembali"><i class="fa fa-arrow-left"></i></a>
</div>
<div class="col-md-11">
    <div style="margin-left:15px;">
        <h4>Menu Pembayaran {{$financing->nama}}</h4>
        <span class="all-pro-ad">Kategori Pembayaran : <strong>{{$financing->jenis}}</strong></span>
    </div>
</div>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('/payment')}}">Pembayaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$financing->nama}}</li>
        </ol>
    </nav>
</div>
@endpush
