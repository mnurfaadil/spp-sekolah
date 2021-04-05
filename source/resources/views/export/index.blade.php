@extends('layouts.app')

@section('title')
SPP | Rekap
@endsection

@section('content')
<div class="widgets-programs-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="hpanel widget-int-shape responsive-mg-b-30">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Pemasukan</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="educate-icon educate-department" style="color:#27ae60"></i>
                        </div>
                        <div class="m-t-xl widget-cl-1">
                            <h1 class="text-success" style="color:#27ae60">Rp. {{number_format($rekap->pemasukan,0,',','.')}}</h1>
                            <!-- <form action="{{route('pdf.print')}}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="id" value="pemasukan">
                            
                            </form> -->
                            <!-- <button type="submit" class="btn btn-block loginbtn" style="background-color:#27ae60;color:white">
                            </button> -->
                            <a href="{{route('rekap.pemasukan')}}" class="btn btn-block loginbtn" style="background-color:#27ae60;color:white">
                                <i class="fa fa-eye"></i>
                                {{ __('Detail') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="hpanel widget-int-shape responsive-mg-b-30">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Pengeluaran</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="educate-icon educate-apps" style="color:#f39c12"></i>
                        </div>
                            <div class="m-t-xl widget-cl-2">
                            <h1 class="text-info" style="color:#f39c12">Rp. {{number_format($rekap->pengeluaran,0,',','.')}}</h1>
                            <!-- <form action="{{route('pdf.print')}}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="id" value="pengeluaran">
                            <button type="submit" class="btn btn-block loginbtn" style="background-color:#f39c12;color:white">
                            <i class="fa fa-print"></i>
                                {{ __('Cetak') }}
                            </button>
                            </form> -->
                            <a href="{{route('rekap.pengeluaran')}}" class="btn btn-block loginbtn" style="background-color:#f39c12;color:white">
                                <i class="fa fa-eye"></i>
                                {{ __('Detail') }}
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Buku Besar</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="fa fa-bookmark-o" style="color:#2980b9"></i>
                        </div>
                        <div class="m-t-xl widget-cl-3">
                            <h1 class="text-success" style="color:#2980b9">Rp. {{number_format($rekap->saldo,0,',','.')}}</h1>
                            <!-- <form action="{{route('pdf.print')}}" method="post" target="_blank">
                                @csrf
                                <input type="hidden" name="id" value="BukuBesar">
                            <button type="submit" class="btn btn-block loginbtn" style="background-color:#2980b9;color:white">
                            <i class="fa fa-print"></i>
                                {{ __('Cetak') }}
                            </button>
                            </form> -->
                            <a href="{{route('rekap.bukbes')}}" class="btn btn-block loginbtn" style="background-color:#2980b9;color:white">
                                <i class="fa fa-eye"></i>
                                {{ __('Detail') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="hpanel widget-int-shape res-tablet-mg-t-30 dk-res-t-pro-30">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Tunggakan</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="fa fa-times" style="color:#e74c3c"></i>
                        </div>
                        <div class="m-t-xl widget-cl-4">
                            <h1 class="text-danger">Rp. {{number_format($tunggakan,0,',','.')}}</h1>
                            <a class="btn btn-block loginbtn" data-toggle="modal" href="#modalAdd" style="background-color:#e74c3c;color:white">
                            <i class="fa fa-eye"></i>
                                {{ __('Detail') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal add -->
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalAddLabel">Laporan Tunggakan</h5>
            </div>
            <div class="modal-body">
                <div class="basic-login-form-ad">
                    <form action="{{route('rekap.store')}}" role="form" method="post" >
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="control-label col-md-4">Lihat berdasarkan<kode>*</kode></label>
                            <div class="chosen-select-single mg-b-20">
                                <select class="chosen-select" name="jenis_kategori" id="category" required>
                                    <option value="Siswa">Siswa</option>
                                    <option value="Kategori">Kategori</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-danger" data-dismiss="modal" tabindex="-1" value="Close">
                    <button type='submit' class="btn btn-primary"><i class="fa fa-eye"></i> {{ __('Detail') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Static Table End -->
@endsection

@push('styles')
<!-- forms CSS
============================================ -->
<link rel="stylesheet" href="{{asset('assets/css/form/all-type-forms.css')}}">
<!-- chosen CSS
============================================ -->
<link rel="stylesheet" href="{{asset('assets/css/chosen/bootstrap-chosen.css')}}">
<!-- x-editor CSS  -->
<link rel="stylesheet" href="{{ asset('assets/css/editor/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/bootstrap-editable.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/x-editor-style.css') }}">
<!-- normalize CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-table.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-editable.css') }}">
<style>
    kode {
        color: red;
    }
</style>
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
<!-- chosen JS
============================================ -->
<script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
<script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script>

<script>
    function change_category()
    {
        var category = $('#category').val() == "" ? "NULL" : $('#category').val();
        $.get('{{ url('') }}/export/ajax/major/' + category, function(data){
            var t = $('#major_id_add').empty();
            var temp = {major_id: "all", nama: "Semua"};
            data.unshift(temp);
            $.each(data, function (i, val) {
                // $("#major_id_add").append(`<option value="${val.major_id}">${val.nama}</option>`); 
                // $("#major_id_add").append(`<option value="cek">cek sound</option>`); 
            });
        });
        $.get('{{ url('') }}/export/ajax/kelas/' + category, function(data){
            var temp = {major_id: "all", nama: "Semua"};
            $('#kelas_add').empty()
            data.unshift(temp);
            $.each(data, function (i, val) {
                if(i === 0)
                {
                    $("#kelas_add").append(`<option value="${val.major_id}">${val.nama}</option>`); 
                }
                else
                {
                    $("#kelas_add").append(`<option value="${val.kelas}">${val.kelas}</option>`); 
                }
            });
        });
    }

    function change_major() {
        var category = $('#category').val() == "" ? "NULL" : $('#category').val();
        var major = $('#major_id_add').val() == "" ? "NULL" : $('#major_id_add').val();
        $.get(`{{ url('') }}/export/ajax/kelas/${category}/${major}`, function(data){
            var temp = {major_id: "all", nama: "Semua"};
            $('#kelas_add').empty()
            data.unshift(temp);
            $.each(data, function (i, val) {
                if(i === 0)
                {
                    $("#kelas_add").append(`<option value="${val.major_id}">${val.nama}</option>`); 
                }
                else
                {
                    $("#kelas_add").append(`<option value="${val.kelas}">${val.kelas}</option>`); 
                }
            });
        });
    }

    $('document').ready(function () {
        $('#category').change(change_category);
        $('#major_id_add').change(change_major);
        var cek = $('#major_id_add');
    });
</script>
@endpush

@push('breadcrumb-left')
<h3>Rekapitulasi</h3>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekapitulasi</li>
        </ol>
    </nav>
</div>
@endpush