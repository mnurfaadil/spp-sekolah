@extends('layouts.app')

@section('title')
SPP | Registrasi
@endsection

@section('content')
<!-- Static Table Start -->
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-graph" style="margin-top: 20px">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                            </div>
                            
                            <h3>Pilih Pembayaran</h3>
            <select name="student" id="student" class="form-control">
                <option value="">== Pilih Siswa ==</option>
                @foreach ($students as $id => $nama)
                    <option value="{{ $id }}">{{ $nama }}</option>
                @endforeach
            </select>
            <select name="kategori" id="kategori" class="form-control">
                <option value="">== Pilih Kategori Pembayaran ==</option>
            </select>


                                            
                        </div>
                        <br>
                        <input type="submit" name="simpan" class="btn btn-primary">
                        <!-- <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <div style="text-align: center">
                                        <th data-field="id"><div style="text-align: center">Nis</div></th>
                                        <th data-field="name"><div style="text-align: center">Nama</div></th>
                                        <th data-field="jenis"><div style="text-align: center">Jenis Kelamin</div></th>
                                        <th data-field="besaran"><div style="text-align: center">Kelas</div></th>
                                        </div>
                                    </tr>
                                </thead>
                                <div class="col-auto">
    <input type="text" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" name="nim" placeholder="NAMA....">
  </div>
</div>
                                
                                
                            </table> -->
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Static Table End -->


@endsection

@push('styles')
 <!-- x-editor CSS   -->
<link rel="stylesheet" href="{{ asset('assets/css/editor/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/bootstrap-editable.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/editor/x-editor-style.css') }}">
 <!-- normalize CSS  -->
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-table.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/data-table/bootstrap-editable.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="select2/dist/css/select2.min.css">
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
@endpush
 
@push('scripts')

<script>
    function editConfirm(id, nama, besaran) {
        $('#nama').attr('value', nama);
        $('#besaran').attr('value', besaran);
        
        $('#editForm').attr('action', "{{ url('financing') }}/" + id);
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

<script type="text/javascript">
// window.addEventListener('DOMContentLoaded', function() {    
    $(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $('#student').on('change', function () {
            url= '{{ route('registrasi.store') }}',
            method= 'POST',   
            data= {id: $(this).val()},
            success= function (response) {
                $('#kategori').empty();
                $.each(response, function (id, name){
                    $('#kategori').append(new Option(name, id))
                })
            } 
        });
    });
// });
</script>
<!--  data table JS
        ============================================  -->
<script src="{{ asset('assets/js/data-table/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/data-table/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/data-table/data-table-active.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-editable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-editable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-resizable.js') }}"></script>
<script src="{{ asset('assets/js/data-table/colResizable-1.5.source.js') }}"></script>
<script src="{{ asset('assets/js/data-table/bootstrap-table-export.js') }}"></script>
  <!-- editable JS
        ============================================  -->
<script src="{{ asset('assets/js/editable/jquery.mockjax.js') }}"></script>
<script src="{{ asset('assets/js/editable/mock-active.js') }}"></script>
<script src="{{ asset('assets/js/editable/select2.js') }}"></script>
<script src="{{ asset('assets/js/editable/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/editable/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/editable/bootstrap-editable.js') }}"></script>
<script src="{{ asset('assets/js/editable/xediable-active.js') }}"></script>
<!-- Select2 -->
<script src="select2/dist/js/select2.min.js"></script>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
 -->
<script type="text/javascript">
$(function () {

});    
</script>

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
<h3>Registrasi Pembayaran</h3>
<small class="text-muted">Klik process untuk melakukan transaksi</small>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembayaran</li>
        </ol>
    </nav>
</div>
@endpush