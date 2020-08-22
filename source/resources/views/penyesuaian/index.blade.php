@extends('layouts.app')

@section('title')
SPP | Pengeluaran
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
                              <div style="float:right;">
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
                            data-show-footer="true" 
                            data-show-pagination-switch="true" 
                            data-show-refresh="true" 
                            data-key-events="true" 
                            data-show-toggle="true" 
                            data-resizable="true" 
                            data-side-pagination="server"
							data-url="/penyesuaian/ajax"
                            data-cookie="true"
                            data-cookie-id-table="saveId" 
                            data-show-export="true" 
                            data-click-to-select="true" 
                            data-toolbar="#toolbar"
                            >
                                <thead>
                                    <tr>
                                        <th data-formatter="runningFormatter" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="center">No</th>
                                        <th data-field="updated_at" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="center">Tanggal</th>
                                        <th data-field="title" data-sortable="true" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="left">Judul</th>
                                        <th data-field="description" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="left">Deskripsi</th>
                                        <th data-field="sumber" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="center">Sumber</th>
                                        <th data-field="nominal" data-halign="center" 
										data-footer-formatter="totalFormatter" data-align="right"
										data-formatter="parseRupiah">Nominal</th>
                                        <th data-field="action" data-halign="center" 
										data-footer-formatter="idFormatter" data-align="center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
<div class="modal fade bd-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="modalAddLabel">Tambah Pengeluaran</h5>
      </div>
      <div class="modal-body">
      <div class="basic-login-form-ad">

      </div>
    </div>
  </div>
</div>

<!-- modal edit -->
<div class="modal fade bd-example-modal-lg" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title" id="modalUpdateLabel">Ubah Pengeluaran</h5>
      </div>
      <div class="modal-body">
      <div class="basic-login-form-ad">
        
      </div>
    </div>
  </div>
</div>

<!-- hapus -->
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
@endpush

@push('scripts')

    <script>

	function parseRupiah (bilangan)
	{
		var	reverse = bilangan.toString().split('').reverse().join(''),
			ribuan 	= reverse.match(/\d{1,3}/g);
			ribuan	= ribuan.join('.').split('').reverse().join('');
		return ribuan;
	}
	function idFormatter() {
		return ''
	}
	function totalFormatter(data) {
		var field = this.field
		return '<b>' + 'Rp. ' + parseRupiah(data.map(function (row) {
			return +row[field].substring(0)
		}).reduce(function (sum, i) {
			return sum + i
		}, 0)) + '</b>'
	}
	
	function runningFormatter(value, row, index) {
		$table = $('#table'); // your tablegrid id
        var tableOptions = $table.bootstrapTable('getOptions');
        return ((tableOptions.pageNumber-1) * tableOptions.pageSize)+(1 + index);
	}
    
    function editConfirm(tanggal, id,title,description,sumber,nominal)
    {
      $('#title').attr('value',title);
      $('#description').html(description);
      $('#nominal').attr('value',nominal);
      $('#tanggal_edit').attr('value', tanggal);
      $('#sumber_edit').val(sumber);
      $('#sumber_edit_chosen .chosen-single span').html(sumber);
      
      $('#editPengeluaran').attr('action',"{{ url('expense') }}/"+id)
      $('#modalUpdate').modal();
    }

    function destroy(action){
        swal({
            title: 'Apakah anda yakin?',
            text: 'Setelah dihapus, Anda tidak akan dapat mengembalikan data ini!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
            document.getElementById('destroy-form').setAttribute('action', action);
            document.getElementById('destroy-form').submit();
            }else {
            swal("Data kamu aman!");
        }
        });
    }
    </script>
    
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

    <script>
		// var url = "{{ url('') }}/penyesuaian/ajax?limit=10";
		// $.get(url, function (res) {
		// 	console.log('====================================');
		// 	console.log(res);
		// 	console.log(res.total);
		// 	console.log('====================================');
		// });
		// $('#table').bootstrapTable('destroy').bootstrapTable({
		// 	pagination : true,
		// 	url: url,
		// 	sidePagination: 'server',
		// });
    </script>
  @endpush

@push('breadcrumb-left')
<h3>Data Pengeluaran</h3>
@endpush

@push('breadcrumb-right')
<div style="float:right">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-bottom:0">
            <li class="breadcrumb-item"><a href="{{ url('/')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
        </ol>
    </nav>
</div>
@endpush
