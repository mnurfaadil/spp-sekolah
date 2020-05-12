@extends('layouts.app')

@section('title')
SPP | Kategori Pembayaran
@endsection

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                              
                            <div id="table_content">
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
                                                <th data-field="jurusan" data-editable="false"><div style="text-align:center">Jurusan</div></th>
                                                <th data-field="nominal" data-editable="false"><div style="text-align:center">Nominal Standar (Rp.)</div></th>
                                                <th data-field="action" data-editable="false"><div style="text-align:center">Action</div></th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_content_body">
                                            @php 
                                            $no=1;
                                                $bulan=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];                                            
                                            @endphp
                                            @foreach($periodes as $periode)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $periode->major->nama }}</td>
                                                <td>
                                                    <div style="text-align:right">
                                                      {{ number_format($periode->nominal,0,',','.') }}
                                                    </div>
                                                </td>
                                                <td>
                                                <div style="text-align:center">
                                                <a href="{{route('periode.all.setting',[$periode->financing_category_id, $periode->major_id])}}" class="btn btn-info" style="margin:0;"><i class="fa fa-gear"></i> Setting</a>                                              
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
    <!-- chosen JS
		============================================ -->
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
    <script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script> 
@endpush


@push('breadcrumb-left')
<a href="{{url('/financing')}}" style="text-decoration:none">
<button  class="btn btn-primary"> Kembali</button>
</a>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/financing')}}">Pembiayaan</a></li>
            <li class="breadcrumb-item"><a href="#">{{ $category[0]->nama}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jurusan</li>
        </ol>
    </nav>
</div>
@endpush