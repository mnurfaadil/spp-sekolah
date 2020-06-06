@extends('layouts.app')

@section('title')
SPP | Kategori Pembayaran
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
                                        <a style="float:right" data-toggle="modal" href="#modalAdd"
                                            class="btn btn-success" title="Tambah"><i class="fa fa-plus"></i> Tambah
                                        </a>
                                        
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
                                        <th data-field="id"><div style="text-align: center">No</div></th>
                                        <th data-field="name"><div style="text-align: center">Deskripsi</div></th>
                                        <th data-field="besaran"><div style="text-align: center">Besaran Terkecil (Rp.)</div></th>
                                        <th data-field="jenis"><div style="text-align: center">Jenis Pembiayaan</div></th>
                                        <th data-field="jurusan"><div style="text-align: center">Peruntukan</div></th>
                                        <th data-field="action"><div style="text-align: center">Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($datas as $data)
                                    @php
                                    $nominal = $data->periode->min('nominal');
                                    $count_jurusan = $data->periode->groupBy('major_id')->count();
                                    $count_angkatan = $data->periode->groupBy('angkatan_id')->count();
                                    @endphp
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>
                                            <div style="text-align: right">
                                            {{number_format($nominal, 0, ",", ".")}}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="text-align: center">{{$data->jenis}}</div>
                                        </td>
                                        <td>
                                            <div style="text-align: center">
                                            @if($count_jurusan < 2 )
                                                <span class="label-warning label-3 label" style="font-size:10pt;color:black">{{$data->periode->first()->major->nama}}</span>
                                            @else
                                            <span class="label-purple label-6 label" style="font-size:10pt;">Semua Jurusan</span>
                                            @endif
                                            @if($count_angkatan < 2)
                                            <span class="label-success label-3 label" style="font-size:10pt;color:black">Angkatan ke - {{$data->periode->first()->angkatan->angkatan}} ({{$data->periode->first()->angkatan->tahun}})</span>
                                            @else
                                            <span class="label-danger label-1 label" style="font-size:10pt">Semua Angkatan</span>
                                            @endif
                                            </div>
                                        </td>
                                        <td>
                                        <div style="text-align: center">
                                            @if($data->history->count()>1)
                                            <a href="#" class="btn btn-info"
                                                onclick="history('{{$data->nama}}','{{ number_format($nominal, 0, ",", ".")}}', '{{$data->jenis}}','{{ url('financing/history',$data->id) }}')"
                                                title="History"><i class="fa fa-history"> History</i></a>
                                            @endif

                                            @if($count_angkatan > 1 && $count_jurusan > 1)
                                            <a href="{{route('periode.all',$data)}}" class="btn btn-success" title="Atur nominal biaya"><i class="fa fa-gear"> Setting</i></a>
                                            @elseif($count_angkatan > 1)
                                            <a href="{{route('periode.angkatan.setting',$data)}}" class="btn btn-success" title="Atur nominal biaya"><i class="fa fa-gear"> Setting</i></a>
                                            @elseif($count_jurusan > 1)
                                            <a href="{{route('periode.jurusan.setting',$data)}}" class="btn btn-success" title="Atur nominal biaya"><i class="fa fa-gear"> Setting</i></a>
                                            @endif

                                            <a href="#" class="btn btn-warning"
                                                onclick="editConfirm({{$data}}, '{{$nominal}}', {{$count_jurusan}}, {{$count_angkatan}})"
                                                title="Edit"><i class="fa fa-edit"> Edit</i></a>
                                            <a href="{{ route('financing.destroy',$data) }}" class="btn btn-danger"
                                                onclick="event.preventDefault();destroy('{{ route('financing.destroy',$data) }}');"
                                                title="Hapus"><i class="fa fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="modalAddLabel">Tambah Kategori Pembiayaan</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('financing.store') }}" role="form" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="control-label col-md-2">Kategori</label>
                        <input name='nama' placeholder="Masukan ketegori pembiayaan" type='text' class='form-control'
                            required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Peruntukan</label>
                        <div class="chosen-select-single mg-b-20">
                            <select class="form-control" name="jurusan"  required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="all">Semua Jurusan</option>
                                @foreach($majors as $major)
                                    <option value="{{$major->id}}">{{$major->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="chosen-select-single mg-b-20">
                            <select class="form-control" name="angkatan"  required>
                                <option value="">-- Pilih Angkatan --</option>
                                <option value="all">Semua Angkatan</option>
                                @foreach($angkatans as $angkatan)
                                    <option value="{{$angkatan->id}}">Kelas {{$angkatan->status}} - Angkatan {{$angkatan->angkatan}} - ({{$angkatan->tahun}})   </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Besaran Nominal (Rp.)</label>
                        <input name='besaran' placeholder="Masukan nominal pembayaran" type='number' min="0"
                            class='form-control' required>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Pembiayaan</label>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="i-checks pull-left">
                                    <label style=""><input type="radio" checked value="Sekali Bayar" name="jenis"> <i></i>  Sekali Bayar</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="i-checks pull-left">
                                    <label>
                                        <input type="radio" value="Bayar per Bulan" name="jenis"> <i></i> Bayar per Bulan 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <hr>
            <p style="font-weight:bold;color:black;margin-left:15px">Mohon diperhatikan !</p>
            <p style="font-weight:bold;color:black;margin-left:15px"> <span style="color:red;"> Kolom peruntukan dan jenis pembiayaan hanya dapat di atur disini </span></p>
            <p style="font-weight:bold;color:black;margin-left:15px">Isilah dengan seksama</p>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" tabindex="-1">Close</button>
                <button type='submit' class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
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
                            id="edit-nama" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Peruntukan</label>
                        <div class="chosen-select-single mg-b-20">
                            <select class="form-control" name="jurusan" id="edit-jurusan" required disabled>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="all">Semua Jurusan</option>
                                @foreach($majors as $major)
                                    <option value="{{$major->id}}">{{$major->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="chosen-select-single mg-b-20">
                            <select class="form-control" name="angkatan" id="edit-angkatan" required disabled>
                                <option value="">-- Pilih Angkatan --</option>
                                <option value="all">Semua Angkatan</option>
                                @foreach($angkatans as $angkatan)
                                    <option value="{{$angkatan->id}}">Kelas {{$angkatan->status}} - Angkatan {{$angkatan->angkatan}} - ({{$angkatan->tahun}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Besaran Nominal (Rp.)</label>
                        <input name='besaran_old' type='hidden' min="0" class='form-control' id="edit-besaran-hidden" required>
                        <input name='edit_jenis' type='hidden' min="0" class='form-control' id="edit-jenis-hidden" required>
                        <input name='besaran' placeholder="Masukan nominal pembayaran" type='number' min="0" class='form-control' id="edit-besaran" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Pembiayaan</label>
                        <input name="edit_jenis" type="text" disabled id="edit-jenis"  class='form-control' required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" tabindex="-1">Close</button>
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
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        Jenis Pembiayaan
                    </div>
                    : <strong><span id="jenis_history_modal"></span></strong>
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
                                        <th>Jenis Pembiayaan</th>
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
@endpush

@push('scripts')

<script>
    function editConfirm(data, besaran, jurusan, angkatan) {
        $('#edit-nama').val(data.nama);
        $('#edit-jurusan').val((jurusan > 1) ? "all" : data.periode[0].major.id);
        $('#edit-angkatan').val((angkatan > 1) ? "all" : data.periode[0].angkatan.id);
        $('#edit-besaran-hidden').attr('value', besaran);
        $('#edit-jenis-hidden').attr('value', data.jenis);
        $('#edit-besaran').attr('value', besaran);
        $('#edit-jenis').attr('value', data.jenis);
        $('#editForm').attr('action', "{{ url('financing') }}/" + data.id);
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

<script>
function history(nama, besaran, jenis='', link = "/"){

    $('#kategori_history_modal').html(nama);
    $('#besaran_history_modal').html(besaran);
    $('#jenis_history_modal').html(jenis);
    $.ajax({
        type: "GET",
        dataType: "json",
        url: link,
        success: function (response) {
            $.each(response, function(i, item) {
                var $tr = $('<tr>').append(
                    $('<td>').text(item.rowNumber),
                    $('<td>').text(item.created_at),
                    $('<td>').text('Rp. '+item.besaran),
                    $('<td>').text(item.jenis)
                ).appendTo('#table_history');
            });
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
<h3>Data Kategori Pembiayaan</h3>
<small>Tombol history muncul kalau ada perubahan data</small>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembiayaan</li>
        </ol>
    </nav>
</div>
@endpush