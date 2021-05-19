@extends('layouts.app')

@section('title')
SPP | Laporan Pemasukan
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
                                        <form action="{{route('rekap.pemasukan.filter')}}" role="form" method="post">
                                        @csrf
                                            <div style="float:left; display:flex; flex-direction:row; max-height:55">
                                                <select class="form-control" style="margin-right:5px; width:150px" name="filter" id="filter" required>
                                                    <option value="all">Semua</option>
                                                    <option value="tahunan">Tahunan </option>
                                                    <option value="bulanan">Bulanan </option>
                                                    <option value="harian">Harian </option>
                                                </select>
                                                <select class="form-control" name="pilihan" id="pilihan" required>
                                                    <option value="">-- Pilih --</option>
                                                </select>
                                                <button type='submit' class="btn btn-info" style="margin-left:5px;">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{route('rekap.pemasukan.export')}}" target="_blank" role="form" id="cetak" method="post">
                                            @csrf
                                            <input type="hidden" name="filter" value="{{$filter}}">
                                            <input type="hidden" name="pilihan" value="{{$pilihan}}">
                                            <button type='button' onclick="validate()" class="btn btn-primary pull-right" style="margin-left:5px;"><i class="fa fa-print" ></i> Cetak</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="no"><div style="text-align:center;">No</div></th>
                                        <th data-field="foto"><div style="text-align:center;">Foto</div></th>
                                        <th data-field="tanggal"><div style="text-align:center;">Tanggal</div></th>
                                        <th data-field="deskripsi"><div style="text-align:center;">Deskripsi</div></th>
                                        <th data-field="nominal"><div style="text-align:center;">Nominal</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($datas as $data)
                                        @php
                                            $url="";
                                            $total =$total + intval($data->debit);
                                            if(isset($data->pemasukan)){
                                                $url = "nota/{$data->pemasukan->foto}";
                                                $url = asset('').$url;
                                            }
                                            $temp = strtotime($data->updated_at);
                                            $tanggal = date('j - M - Y', $temp); 
                                        @endphp
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>
                                                @if($data->tipe=="img")
                                                <img style="height:50; width:50;" src="{{$url}}" alt="Foto Bukti"/>
                                                @else
                                                &nbsp;
                                                @endif
                                            </td>
                                            <td style="text-align:left;">{{$tanggal}} </td>
                                            <td style="text-align:left;word-wrap:break-word;">{{$data->description}}</td>
                                            <td style="text-align:right">{{number_format($data->debit,0,',','.')}}</td>
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
                                                                    <td>Total </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:24px;color:green">
                                                                                <strong>{{number_format($total,0,',','.')}}</strong>
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

        @endpush

        @push('scripts-asset')
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

        <!-- input-mask JS
		============================================ -->
        <script src="{{ asset('assets/js/input-mask/jasny-bootstrap.min.js')}}"></script>

        <!-- datapicker JS
		============================================ -->
        <script src="{{ asset('assets/js/datapicker/bootstrap-datepicker.js')}}"></script>
        <script src="{{ asset('assets/js/datapicker/datepicker-active.js')}}"></script>

        <!-- Custom Script -->
        <!-- ============================================ -->
        <script>
            function change_filter() {
                var filter = $('#filter').val();
                if(filter === 'all')
                {
                    var cek = $('input[type=hidden][name=filter]').val();
                    if(cek === '')
                    {
                        $('input[type=hidden][name=filter]').val(filter);
                        $('input[type=hidden][name=pilihan]').val(filter);
                    }
                    $('#pilihan').empty();
                    $('#pilihan').append(`<option value="all">Semua</option>`);
                }
                else
                {
                    $('input[type=hidden][name=pilihan]').val('');
                    $('input[type=hidden][name=filter]').val(filter);
                    $.get(`{{ url('') }}/rekap_Pemasukan/ajax/${filter}`, function(data){
                        var temp = {tanggal: "-- Pilih --", tanggal_value: ""};
                        data.unshift(temp);
                        $('#pilihan').empty();
                        $.each(data, function (i, val){
                            $('#pilihan').append(`<option value="${val.tanggal_value}">${val.tanggal}</option>`);
                        });
                    });
                }
            }
            function change_pilihan() {
                var pilihan = $('#pilihan').val();
                var filter = $('#filter').val();
                if(filter != 'all')
                {
                    $('input[type=hidden][name=pilihan]').val(pilihan);
                }
            }
            function validate() {
                var pilihan = $('input[type=hidden][name=pilihan]').val();
                if (pilihan === '')
                {
                    swal({
                        title: 'Peringatan',
                        text: 'Form pilihan filter tidak boleh kosong!',
                        icon: 'warning',
                    });
                }
                else
                {
                    $('#cetak').submit();
                }
            }
            $('#filter').change(change_filter);
            $('#pilihan').change(change_pilihan);
            $(document).ready(function(){
                change_filter();
                change_pilihan();
            });
        </script>
        @endpush

        @push('breadcrumb-left')
        <div class="col-md-1" style="item-align:center">
            <a href="{{ url('/rekap')}}" class="btn btn-primary" href="#" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
        </div>
        <div class="col-md-11">
            <div style="margin-left:15px;">
                <h3>Data Laporan Pemasukan</h3>
            </div>
        </div>
        @endpush


        @push('breadcrumb-right')
        <div style="float:right">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="margin-bottom:0">
                    <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/rekap')}}">Rekap</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Pemasukan</li>
                </ol>
            </nav>
        </div>
        @endpush
