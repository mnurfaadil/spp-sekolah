@extends('layouts.app')

@section('title')
SPP | Laporan Pengeluaran
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
                                        <form action="{{route('rekap.tunggakan.filter', $stat)}}" role="form" method="post">
                                            @csrf
                                            <input type="hidden" name="stat" value="{{$stat}}">
                                            <div style="float:left; display:flex; flex-direction:row; max-height:55">
                                                <select class="form-control" style="margin-right:5px; width:150px" name="kelas" id="kelas" required>
                                                    <option value="all">Semua Kelas</option>
                                                </select>
                                                <select class="form-control" style="margin-right:5px; width:150px" name="jurusan" id="jurusan" required>
                                                    <option value="all">Semua Jurusan</option>
                                                </select>
                                                <select class="form-control" style="margin-right:5px; width:150px" name="angkatan" id="angkatan" required>
                                                    <option value="all">Semua Angkatan<option>
                                                </select>
                                                <button type='submit' class="btn btn-info" style="margin-left:5px;">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{route('rekap.tunggakan.export')}}" target="_blank" role="form" id="cetak" method="post">
                                            @csrf
                                            <input type="hidden" name="stat" value="{{$stat}}">
                                            <input type="hidden" name="keyword" value="">
                                            <input type="hidden" name="kelas" value="{{$kelas}}">
                                            <input type="hidden" name="jurusan" value="{{$jurusan}}">
                                            <input type="hidden" name="angkatan" value="{{$angkatan}}">
                                            <input type="hidden" name="check_options" value="">
                                            <button type='button' onclick="validate()" class="btn btn-primary pull-right" style="margin-left:5px;"><i class="fa fa-print" ></i> Cetak</button>
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
                            data-search="true" 
                            data-show-columns="true" 
                            data-show-pagination-switch="true" 
                            data-show-refresh="true" 
                            data-key-events="true" 
                            data-show-toggle="true" 
                            data-resizable="true" 
                            data-cookie="true"
                            data-cookie-id-table="saveId" 
                            data-show-export="true" 
                            data-click-to-select="true" 
                            data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-checkbox="true"></th>
                                        <th data-field="id" data-visible="false">Id</th>
                                        <th data-field="no"><div style="text-align:center;">No</div></th>
                                        <th data-field="nama"><div style="text-align:center;">Nama</div></th>
                                        <th data-field="kelas"><div style="text-align:center;">Kelas</div></th>
                                        <th data-field="jurusan"><div style="text-align:center;">Jurusan</div></th>
                                        <th data-field="angkatan"><div style="text-align:center;">Angkatan</div></th>
                                        <th data-field="kategori"><div style="text-align:center;">Kategori</div></th>
                                        <th data-field="besaran"><div style="text-align:center;">Besaran</div></th>
                                        <th data-field="potongan"><div style="text-align:center;">Potongan</div></th>
                                        <th data-field="terbayar"><div style="text-align:center;">Terbayar</div></th>
                                        <th data-field="sisa"><div style="text-align:center;">Sisa</div></th>
                                    </tr>
                                </thead>
                                @php
                                    $total = [0,0,0,0];
                                @endphp
                            </table>
                                    <div class="container-sm" style="margin-top:10px">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="float:right; margin-right:20%">
                                                    <div class="row">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Besaran Keseluruhan </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="besaran_view_2"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Potongan Keseluruhan  </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="potongan_view_2"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Terbayar Keseluruhan </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="terbayar_view_2"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sisa Keseluruhan </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:24px;color:red">
                                                                                <strong id="sisa_view_2"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right; margin-right:20%">
                                                    <div class="row">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Besaran </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="besaran_view"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Potongan </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="potongan_view"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Terbayar </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:20px;">
                                                                                <strong id="terbayar_view"></strong>
                                                                            </span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Sisa </td>
                                                                    <td>:</td>
                                                                    <td>Rp.</td>
                                                                    <td>
                                                                        <div style="text-align: right">
                                                                            <span class="" style="font-size:24px;color:red">
                                                                                <strong id="sisa_view"></strong>
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
            function change_kelas() {
                var kelas = $('#kelas').val();
                var pilihan = $('input[type=hidden][name=kelas]').val(kelas);
            }
            function change_jurusan() {
                var jurusan = $('#jurusan').val();
                var pilihan = $('input[type=hidden][name=jurusan]').val(jurusan);
            }
            function change_angkatan() {
                var angkatan = $('#angkatan').val();
                var pilihan = $('input[type=hidden][name=angkatan]').val(angkatan);
            }
            function load_kelas() {
                $.get(`{{ url('') }}/rekap_tunggakan/ajax/{{$stat}}/Kelas`, function(data){
                    var temp = {kategori: "Semua Kelas", kategori_value: "all"};
                    data.unshift(temp);
                    $('#kelas').empty();
                    $.each(data, function (i, val){
                        $('#kelas').append(`<option value="${val.kategori_value}">${val.kategori}</option>`);
                    });
                });
            }
            function load_jurusan() {
                $.get(`{{ url('') }}/rekap_tunggakan/ajax/{{$stat}}/Jurusan`, function(data){
                    var temp = {kategori: "Semua Jurusan", kategori_value: "all"};
                    data.unshift(temp);
                    $('#jurusan').empty();
                    $.each(data, function (i, val){
                        $('#jurusan').append(`<option value="${val.kategori_value}">${val.kategori}</option>`);
                    });
                });
            }
            function load_angkatan() {
                $.get(`{{ url('') }}/rekap_tunggakan/ajax/{{$stat}}/Angkatan`, function(data){
                    var temp = {kategori: "Semua Angkatan", tahun: "", kategori_value: "all"};
                    data.unshift(temp);
                    $('#angkatan').empty();
                    $.each(data, function (i, val){
                        if (i === 0)
                        {
                            $('#angkatan').append(`<option value="${val.kategori_value}">${val.kategori}</option>`);
                        }
                        else
                        {
                            $('#angkatan').append(`<option value="${val.kategori_value}">${val.kategori} (${val.tahun})</option>`);
                        }
                    });
                });
            }
            function validate() {
                var kelas = $('input[type=hidden][name=kelas]').val();
                var jurusan = $('input[type=hidden][name=jurusan]').val();
                var angkatan = $('input[type=hidden][name=angkatan]').val();
                if (kelas === '' || jurusan === '' || angkatan === '' )
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
            $('#kelas').change(change_kelas);
            $('#jurusan').change(change_jurusan);
            $('#angkatan').change(change_angkatan);
            
            function change_search() {
                let val = $(this).val();
                var pilihan = $('input[type=hidden][name=keyword]').val(val);
                $.get(`{{ url('') }}/rekap_tunggakan/_ajax/data/${val}`, function(data){
                    data = JSON.parse(data);
                    $('#besaran_view').text(data.besaran);
                    $('#potongan_view').text(data.potongan);
                    $('#terbayar_view').text(data.terbayar);
                    $('#sisa_view').text(data.sisa);
                });
            }
            
            $(document).ready(function(){
                load_kelas();
                load_jurusan();
                load_angkatan();
                let search = document.getElementsByClassName('search');
                let form = search[0].lastChild;
                form.addEventListener("keyup", change_search);
            });
        </script>

        <script>
            var $table = $('#table');
            var selections = [];

            function getIdSelections() {
                return $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id
                })
            }

            function getAllIdSelections() {
                return $.map($table.bootstrapTable('getData'), function (row) {
                    return row.id
                })
            }

            $(function () {
                $table.bootstrapTable('getAllSelections');
                
                $table.on(
                'check.bs.table uncheck.bs.table check-all.bs.table',
                function () {
                    // save your data, here just save the current page
                    selections = getIdSelections();
                    $('input[type=hidden][name=check_options]').val(JSON.stringify(selections));
                    // push or splice the selections if you want to save all data selections
                })

                $table.on(
                ' uncheck-all.bs.table',
                function () {
                    // save your data, here just save the current page
                    selections = getIdSelections();
                    
                    $('input[type=hidden][name=check_options]').val(JSON.stringify(selections));
                    // push or splice the selections if you want to save all data selections
                })
                $table.on('all.bs.table', function (e, name, args) {
                })
            });
            
            var $table = $('#table');
            var selections = [];
            
            function getIdSelections() {
                return $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.id
                })
            }

            function parseRupiah (bilangan)
            {
                var	number_string = bilangan.toString(),
                    sisa 	= number_string.length % 3,
                    rupiah 	= number_string.substr(0, sisa),
                    ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                        
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah;
            }

            $(function () {
                $table.on(
                'search.bs.table page-change.bs.table',
                function () {
                    var temp = $table.bootstrapTable('getData');
                    var total = [0,0,0,0];
                    var li = $('li .active').html();
                    var opt = $table.bootstrapTable('getOptions');
                    var page_size = opt.pageSize;
                    var page_total = opt.totalPages;
                    var data_total = opt.totalRows;
                    var page_number = opt.pageNumber;
                    var limit = page_size * page_number;
                    var i = limit - page_size;
                    while (i < limit && i < data_total) {
                        total[0] += temp[i]._besaran;
                        total[1] += temp[i]._potongan;
                        total[2] += temp[i]._terbayar;
                        total[3] += temp[i]._sisa;
                        i++;
                    }
                    $('#besaran_view').html(parseRupiah(total[0]));
                    $('#potongan_view').html(parseRupiah(total[1]));
                    $('#terbayar_view').html(parseRupiah(total[2]));
                    $('#sisa_view').html(parseRupiah(total[3]));
                })
                $.get('{{ url('') }}/rekap_tunggakan/data_master/Siswa', function(data){
                    setTable(data);
                });

            });
            function setTable(data) {    
                var content = [];
                var no = 0;
                var total = [0,0,0,0];
                var total_ = [0,0,0,0];

                var limit = 10;
                $.each(data, function(i, v){
                    no += 1;

                    var besaran_ = parseInt(v.nominal);
                    var terbayar_ = v.cicilan_dibayar == null ? 0 : parseInt(v.cicilan_dibayar);
                    var potongan_ = parseInt(v.persentase) * parseInt(v.nominal) / 100;

                    var bulan_spp = 36;
                    if (v.nama == 'SPP')
                    {
                        
                        besaran_ = bulan_spp * parseInt(v.nominal);
                        terbayar_ = (bulan_spp - parseInt(v.banyak_tunggakan)) * besaran_;
                        potongan_ = 0;
                    }

                    if (v.jenis_potongan == "nominal") {
                        potongan_ = parseInt(v.nominal_potongan);
                    }

                    var sisa_ = besaran_ - ( terbayar_ + potongan_ );
                    
                    total[0] += besaran_;
                    total[1] += potongan_;
                    total[2] += terbayar_;
                    total[3] += sisa_;

                    if (i < limit)
                    {
                        total_[0] += besaran_;
                        total_[1] += potongan_;
                        total_[2] += terbayar_;
                        total_[3] += sisa_;
                    }

                    var besaran = parseRupiah(besaran_);
                    var potongan = parseRupiah(potongan_);
                    var terbayar = parseRupiah(terbayar_);
                    var sisa = parseRupiah(sisa_);

                    var temp = {
                        id : v.detail_id,
                        _besaran : besaran_,
                        _potongan : potongan_,
                        _terbayar : terbayar_,
                        _sisa : sisa_,
                        no : no,
                        nama : v.nama_murid,
                        kelas : `${v.kelas}`,
                        jurusan : `${v.inisial}`,
                        angkatan : `${v.angkatan} (${v.tahun_angkatan})`,
                        kategori : `${v.nama}`,
                        besaran :   
                        `<div style="text-align:right">
                            ${besaran}
                        </div>`,
                        potongan :
                        `<div style="text-align:right">
                            ${potongan}
                        </div>`,
                        terbayar :
                        `<div style="text-align:right">
                            ${terbayar}
                        </div>`,
                        sisa :
                        `<div style="text-align:right">
                            ${sisa}
                        </div>`
                    }

                    
                    content .push(temp);
                });
                $table.bootstrapTable('destroy').bootstrapTable({
                    exportTypes: ['excel', 'pdf'],
                    data: content
                });
                
                $('#besaran_view_2').html(parseRupiah(total[0]));
                $('#potongan_view_2').html(parseRupiah(total[1]));
                $('#terbayar_view_2').html(parseRupiah(total[2]));
                $('#sisa_view_2').html(parseRupiah(total[3]));
                
                $('#besaran_view').html(parseRupiah(total_[0]));
                $('#potongan_view').html(parseRupiah(total_[1]));
                $('#terbayar_view').html(parseRupiah(total_[2]));
                $('#sisa_view').html(parseRupiah(total_[3]));

            }
        </script>
        @endpush

        @push('breadcrumb-left')
        <div class="col-md-1" style="item-align:center">
            <a href="{{ url('/rekap')}}" class="btn btn-primary" href="#" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
        </div>
        <div class="col-md-11">
            <div style="margin-left:15px;">
                <h3>Data Laporan Tunggakan</h3>
            </div>
        </div>
        @endpush


        @push('breadcrumb-right')
        <div style="float:right">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="margin-bottom:0">
                    <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/rekap')}}">Rekap</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Tunggakan</li>
                </ol>
            </nav>
        </div>
        @endpush
