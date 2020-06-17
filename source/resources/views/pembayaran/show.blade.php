@extends('layouts.app')

@section('title')
SPP | Pembayaran
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
                                    </div>
                                    <div class="col-md-6">
                                        <div style="float:right; margin-right:15px">
                                            <div class="row">
                                                <a href="{{ route('pdf.print.rekap.bulanan',[$financing->nama,$financing->id])}}" style="float:right"class=" btn btn-success" target="_blank">
                                                    <i class="fa fa-print"></i>&nbsp;Cetak
                                                </a>
                                            </div>
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
                                        <th data-field="no">No</th>
                                        <th data-field="name">Nama</th>
                                        <th data-field="kelas">Kelas</th>
                                        <th data-field="total">Akumulasi Biaya</th>
                                        <th data-field="terbayar">Sudah dibayar</th>
                                        <th data-field="sisa">Sisa Pembayaran</th>
                                        <th data-field="tunggakan">Tunggakan</th>
                                        <th data-field="status">Status</th>
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
                <h5 class="modal-title" id="modalAddLabel">Pilih Metode Pembayaran Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('payment.storeMethod') }}" role="form" method="post">
                {{csrf_field()}}
                <input type="hidden" name="financing_category_id" value="{{$financing->id}}">
                <input type="hidden" name="financing_category" value="{{$financing->nama}}">
                <input type="hidden" name="nominal" value="{{$financing->besaran}}">
                <input type="hidden" name="student_id" id="student_id_add" value="">
                <input type="hidden" name="student_name" id="student_name_add" value="">
                <input type="hidden" name="penerima" value="{{ Session::get('nama') }}">
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
                    : <strong>Rp. <span >{{number_format($financing->besaran,0,',','.')}}</span></strong>
                </div>
                <hr>
                <div class="form-group">
                    <label class="control-label col-md-4">Metode Pembayaran<kode>*</kode></label>
                    <div class="chosen-select-single mg-b-20">
                        <select class="chosen-select" name="metode_pembayaran" id="metode_pembayaran_add">
                            <option value="Tunai">Tunai</option>
                            <option value="Cicilan">Cicilan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog"
    aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="modalAddLabel">Ubah Kategori Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" role="form" method="post">
                    @method('PUT')
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-2">Kategori</label>
                        <input name='nama' placeholder="Masukan ketegori pembiayaan" type='text' class='form-control'
                            id="nama" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Besaran Nominal (Rp.)</label>
                        <input name='besaran' placeholder="Masukan nominal pembayaran" type='number' min="0"
                            class='form-control' id="besaran" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal history -->
<div class="modal fade bd-example-modal-lg" id="modalHistory" tabindex="-1" role="dialog"
    aria-labelledby="modalHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="title_modal_history">History Perubahan Data</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-3 col-sm-3">
                        Kategori Pembiayaan
                    </div>
                    :
                    <strong><span id="kategori_history_modal"></span></strong>
                </div>
                
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Besaran Pembiayaan
                    </div>
                    : <strong>Rp. <span id="besaran_history_modal"></span></strong>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="static-table-list">
                            <table class="table" id="table_history">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu Update</th>
                                        <th>Besaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('#table_history tbody tr').remove();">Close</button>
            </div>
        </div>
    </div>
</div>


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

<script>
    function closeModal()
    {
        $('.button_add').bind('click');
    }
    function addConfirm(id_siswa, nama) {
        $('#student_id_add').attr('value',id_siswa);
        $('#student_name_add').attr('value',nama);
        $('#modalAdd').modal();
    }

    function editConfirm() {
        $('#modalUpdate').modal();
    }

    function destroy(action) {
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
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
        var content = [];
        $.get('{{ url('') }}/payment/ajax_perbulan/{{$financing->id}}', function(data){
            $.each(data, function(i, v){
                var nominal = parseInt(v.nominal);
                var sisa = parseInt(v.sisa_bulan);
                var nunggak = parseInt(v.spp_nunggak);
                
                //Total Biaya
                var total = 36 * nominal;
                var total_ = parseRupiah(total);

                //Terbayar
                var terbayar = (36 - sisa) * nominal;
                var terbayar_ = parseRupiah(terbayar);

                //Sisa Pembayaran
                var tersisa = sisa * nominal;
                var tersisa_ = parseRupiah(tersisa);

                //Tunggakan
                if (nunggak != 0)
                {
                    var tunggakan = 
                    `
                    <div style="text-align:center">
                        <span class="badge" style="background-color:red">${nunggak} Bulan</span>
                    </div>
                    `;
                }
                else
                {
                    var tunggakan = 
                    `
                    <div style="text-align:center">
                        ${nunggak} Bulan
                    </div>
                    `;
                }

                //Status
                if (tersisa == 0 && nunggak == 0) {
                    var status =
                    `
                    <div style="text-align:center">
                        <span class="badge" style="background-color:green">Lunas</span>
                    </div>
                    `;
                } else {
                    var status = 
                    `
                    <div style="text-align:center">
                    `;
                    if (sisa != 0) {
                        status += '<span class="badge" style="background-color:yellow;color:black">Waiting</span>';
                    }
                    if (nunggak != 0) {
                        status += '<span class="badge" style="background-color:red">Nunggak</span>';
                    }
                    status += '</div>';
                }
                
                //Action
                var link_detail = `{{ url('payment/perbulan/detail/') }}/${v.id}/${v.student_id}/${v.financing_category_id}`;
                var action =
                `
                    <a href="${link_detail}" 
                    class="btn btn-success"
                    title="Detail Pembayaran" 
                    style="color:white; background-color:green">
                        <i class="fa fa-eye"> Detail</i>
                    </a>
                `;


                var temp = {
                    no: (i+1),
                    name : `${v.nama}`,
                    kelas : `${v.kelas} - ${v.jurusan}`,
                    total : 
                    `
                    <div style="text-align:right">
                        ${total_}
                    </div>
                    `,
                    terbayar : 
                    `
                    <div style="text-align:right">
                        ${terbayar_}
                    </div>
                    `,
                    sisa : 
                    `
                    <div style="text-align:right">
                        ${tersisa_}
                    </div>
                    `,
                    tunggakan : 
                    tunggakan,
                    status : status,
                    action : action
                };

                content.push(temp);
            });
            $table.bootstrapTable('destroy').bootstrapTable({
                exportTypes: ['excel', 'pdf'],
                data: content
            });
        });
    });

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

<!-- chosen JS
    ============================================ -->
<script src="{{ asset('assets/js/chosen/chosen.jquery.js')}}"></script>
<script src="{{ asset('assets/js/chosen/chosen-active.js')}}"></script>

<script>
function history(nama, besaran, link = "/"){

$('#kategori_history_modal').html(nama);
$('#besaran_history_modal').html(besaran);
$.ajax({
    type: "GET",
    dataType: "json",
    url: link,
    success: function (response) {
        $.each(response, function(i, item) {
            var $tr = $('<tr>').append(
                $('<td>').text(item.rowNumber),
                $('<td>').text(item.created_at),
                $('<td>').text('Rp. '+item.besaran)
            ).appendTo('#table_history');
        });
    },
    error: function (error) {
        alert(error);
    }
});
$('#modalHistory').modal();
}</script>
@endpush

@push('breadcrumb-left')
<div class="col-md-1" style="item-align:center">
<a href="{{ url('/payment')}}" class="btn btn-primary" href="#" title="Kembali"><i class="fa fa-arrow-left" ></i></a>
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