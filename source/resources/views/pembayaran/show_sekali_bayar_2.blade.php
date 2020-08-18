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
                                                
                                                <!-- <button type='submit' class="btn btn-info" style="margin-left:5px;">Filter</button> -->
                                            </div>
                                        </form>
                                                <button onclick="changeData()" class="btn btn-info" style="margin-left:5px;padding-vertical:2px;">Filter</button>
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
                            <table id="table" 
                                data-toggle="table" 
                                data-pagination="true" 
                                data-url="{{ url('') }}/payment/ajax/{{$financing->id}}"
                                data-search="true"
                                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="no">No</th>
                                        <th data-field="nama">Nama</th>
                                        <th data-field="kelas">Kelas</th>
                                        <th data-field="besaran">Akumulasi Biaya</th>
                                        <th data-field="persentase">Persentase Potongan</th>
                                        <th data-field="potongan">Nominal Potongan</th>
                                        <th data-field="terbayar">Sudah dibayar</th>
                                        <th data-field="sisa">Sisa Pembayaran</th>
                                        <th data-field="metode">Metode Pembayaran</th>
                                        <th data-field="status">Status</th>
                                        <th data-field="keterangan">Keterangan</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
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
                        <input type="hidden" name="data">
                        <input type="hidden" name="financing_category_id" value="{{$financing->id}}">
                        <input type="hidden" name="financing_category" value="{{$financing->nama}}">
                        <input type="hidden" name="nominal" value="{{$financing->besaran}}">
                        <input type="hidden" name="student_id" id="student_id_add" value="">
                        <input type="hidden" name="penerima" value="{{ Auth::user()->nama }}">
                        <input type="hidden" name="dump" id="dump">
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
                            <label class="control-label col-md-4">Jenis Potongan<kode>*</kode></label>
                            <div class="chosen-select-single mg-b-20">
                                <select class="chosen-select" name="jenis_potongan" id="jenis_potongan_add" autofocus>
                                    <option value="persentase">Persentase</option>
                                    <option value="nominal">Nominal</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" id="label_potongan">Persentase Potongan Biaya (%)<kode>*</kode></label>
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
                            <div class="form-group data-custon-pick" id="data_2">
                                <label class="control-label">Tanggal Pembayaran<kode>*</kode></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" autocomplete="off" class="form-control" required placeholder="Tanggal Pembayaran" name="tanggal_bayar" id="tanggal_bayar_add">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nominal Pembayaran</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><strong>Rp.</strong></span>
                                    <input type="number" min="0" class="form-control" name="nominal_bayar" id="nominal_bayar_add" value="" 
                                    placeholder="Masukan Nominal pembayaran">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-anchor"></i>
                                    </span>
                                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="" 
                                    placeholder="Keterangan">
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
        var raw_url = window.location.pathname;
        var url = raw_url.split("/");
        url = window.location.origin+"/"+url[1]+"/"+url[2]+"/ajax/"+url[3]+"?id="+data;
        $.get(url, function(resp){
            $('input[name=persentase]').val(resp.persentase);
            $('input[name=data]').attr('value', JSON.stringify(data));
            $('input[name=payment_id]').attr('value', resp.id);
            $('input[name=student_id]').attr('value', resp.student_id);
            $('input[name=financing_category_id]').attr('value', resp.financing_category_id);
            $('input[name=nominal]').attr('value', resp.nominal);
            $('input[name=nominal_bayar]').attr('value', resp.nominal);
            $('input[name=nominal_bayar]').attr('min', resp.nominal);
            $('input[name=dump]').attr('value', resp.nominal);
            $('#nominal_show').html(nominal);
            $('#modalAdd').modal();
        })
    }

    $(document).ready(function(){
        var cek = $('select[name=metode_pembayaran]').val();
        if(cek=="Tunai"){
            $('input[name=tanggal_bayar]').attr('required', true);
            $('input[name=nominal_bayar]').attr('required', true);
            $('#tanggal').show();
        }else{
            $('input[name=tanggal_bayar]').removeAttr('required');
            $('input[name=nominal_bayar]').removeAttr('required');
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
            $('input[name=tanggal_bayar]').removeAttr('required');
            $('input[name=nominal_bayar]').removeAttr('required');
            $('#tanggal').hide();
        }
    });

    $('select[name=jenis_potongan]').change(function(){
        var val = $(this).val();
        if (val === "persentase") {
            $('#label_potongan').html('Persentase Potongan Biaya (%)<kode>*</kode>');
            $('#persentase_add').attr('max','100');
        } else {
            $('#label_potongan').html('Nominal Potongan Biaya (Rp)<kode>*</kode>');
            $('#persentase_add').removeAttr('max');
        }
        $('#persentase_add').val("0");
        change_persentase();
    });

    function change_persentase()
    {
        var val = $('select[name=jenis_potongan]').val();
        var number = parseInt($('#dump').val());
        if (val === "persentase") {
            var pers = parseInt($('#persentase_add').val()) > 100 ? 100 : parseInt($('#persentase_add').val());
            var potongan = number * ( pers / 100 );
            potongan = potongan.toString() == 'NaN' ? 0 : potongan;
            if(pers <= 100 && pers >= 0){
                number = number - potongan;
            }
        } else {
            var potongan = parseInt($('#persentase_add').val());
            potongan = potongan.toString() == 'NaN' ? 0 : potongan;
            potongan = potongan > number ? number : potongan;
            number = number - potongan;
        }
        var format = new Intl.NumberFormat(['ban', 'id']).format(number);
        $('input[name=nominal]').val(number);
        $('input[name=nominal_bayar]').attr('min',number);
        $('input[name=nominal_bayar]').val(number);
        $('#nominal_show').html(format);
    }
    $('#persentase_add').change(change_persentase);
    $('#persentase_add').keyup(change_persentase);


    function confirm() {
        event.preventDefault();
        swal({
            title: 'Apakah anda yakin?',
            text: 'Akan mengkonfirmasi pembayaran ini ?',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function (value) {
            if (value) {
                var metode = $('select[name=metode_pembayaran]').val();
                var val = $('select[name=jenis_potongan]').val();
                var per = $('#persentase_add').val();
                var nom = parseInt($('#dump').val());
                if (val === "persentase" && per > 100) {
                    return swal({
                            title : "Error",
                            text : "Silahkan masukan persentase dengan benar!",
                            icon : "warning",
                        });
                }
                if (val === "nominal" && per > nom) {
                    return swal({
                            title : "Error",
                            text : "Silahkan masukan nominal potongan dengan benar!",
                            icon : "warning",
                        });
                }
                if(metode=="Tunai") 
                {
                    var form = $('#store').serializeArray();
                    
                    if(form[13].value==""){
                        swal("Tanggal pembayaran kosong!");
                        bind();
                        return false;
                    }
                    if(form[14].value==""){
                        swal("Uang pembayaran kosong!");
                        bind();
                        return false;
                    }
                    if(parseInt(form[5].value) > parseInt(form[14].value)){
                        swal("Uang pembayaran kurang!");
                        bind();
                        return false;
                    }
                    if(parseInt(form[5].value) < parseInt(form[14].value)){
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
                    else
                    {
                        document.getElementById('store').submit();
                    }
                }
                else
                {
                    document.getElementById('store').submit();
                }
            } else {
                swal("Pembayaran dibatalkan!");
            }
        });
    }
    var $table = $('#table');
    function changeData() {
        var kelas = $('select[name=kelas]').val();
        var jurusan = $('select[name=jurusan]').val();
        var angkatan = $('select[name=angkatan]').val();
        $('input[type=hidden][name=kls]').val(kelas);
        $('input[type=hidden][name=id_jur]').val(jurusan);
        $('input[type=hidden][name=akt]').val(angkatan);
        var url = `{{ url('') }}/payment/ajax/{{ $financing->id }}?kelas=${kelas}&jurusan=${jurusan}&angkatan=${angkatan}`;
        $.ajax({
            url : url,
            beforeSend : function(){
                $table.bootstrapTable('showLoading');
                $table.bootstrapTable('removeAll');
            },
            success : function(response){
                var data = JSON.parse(response);
                $table.bootstrapTable('load', data);
            },
            complete : function(data){
                $table.bootstrapTable('hideLoading');
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
