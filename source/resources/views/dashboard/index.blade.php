@extends('layouts.app')

@section('title')
SPP | Dashboard
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
                            <h1 class="text-success" style="color:#27ae60">Rp. {{number_format($dashboard->pemasukan,0,',','.')}}</h1>
                            <a class="btn btn-block loginbtn" style="background-color:#27ae60;color:white" href="{{route('income.index')}}">
                                {{ __('Pemasukan') }}
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
                            <h1 class="text-info" style="color:#f39c12">Rp. {{number_format($dashboard->pengeluaran,0,',','.')}}</h1>
                            <a class="btn btn-block loginbtn" style="background-color:#f39c12;color:white" href="{{route('expense.index')}}">
                                {{ __('Pengeluaran') }}
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="hpanel widget-int-shape responsive-mg-b-30 res-tablet-mg-t-30 dk-res-t-pro-30">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Jumlah Siswa</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="educate-icon educate-professor" style="color:#2980b9"></i>
                        </div>
                        <div class="m-t-xl widget-cl-3">
                            <h1 class="text-success" style="color:#2980b9">{{number_format($dashboard->siswa,0,',','.')}}</h1>
                            <a class="btn btn-block loginbtn" style="background-color:#2980b9;color:white" href="{{route('students.index')}}">
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
                            <h4>Data Tunggakan</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="fa fa-times" style="color:#e74c3c"></i>
                        </div>
                        <div class="m-t-xl widget-cl-4">
                            <h1 class="text-danger">{{number_format($dashboard->nunggak,0,',','.')}}</h1>
                            <a class="btn btn-block loginbtn" style="background-color:#e74c3c;color:white" href="{{route('payment.index')}}">
                                {{ __('Detail') }}
                            </a>
                        </div>
                    </div>
                </div>
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
@endpush


@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
</div>
@endpush