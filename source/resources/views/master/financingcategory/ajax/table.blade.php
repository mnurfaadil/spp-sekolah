<div class="datatable-dashv1-list custom-datatable-overright">
    <div id="toolbar">
        <select class="form-control dt-tb">
            <option value="">Export Basic</option>
            <option value="all">Export All</option>
            <option value="selected">Export Selected</option>
        </select>
    </div>
    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
        data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true"
        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
        data-click-to-select="true" data-toolbar="#toolbar">
        <thead>
            <tr>
                <th data-field="id">No</th>
                <th data-field="date" data-editable="false">Dari Tabel.bla.de Update</th>
                <th data-field="jurusan" data-editable="false">Jurusan</th>
                <th data-field="nominal" data-editable="false">Nominal</th>
                <th data-field="action" data-editable="false">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no=1;
            $bulan=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            @endphp
            @foreach($periodes as $periode)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $periode->updated_at }}</td>
                <td>{{ $periode->major->nama }} {{ $periode->major_id }} {{ $periode->angkatan_id }}</td>
                <td>
                    <div style="text-align:right">
                        {{ $periode->nominal }}
                    </div>
                </td>
                <td>
                    @if($periode->angkatan->status=="ALUMNI")
                    <div class="alert alert-info" role="alert"
                        style="text-align:center; margin-bottom:0px;padding-top:5px;padding-bottom:5px;">
                        <strong>Alumni</strong>
                    </div>
                    @else
                    <div style="text-align:center">
                        <button class="btn btn-warning editable" title="Edit periode {{$category[0]->nama}}"
                            style="color:white"
                            onclick="editConfirm({{$periode}},'{{ $periode->angkatan->angkatan }} ({{ $periode->angkatan->tahun }})');">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger editable" title="Hapus periode {{$category[0]->nama}}"
                            style="color:white"
                            onclick="event.preventDefault();destroy('{{ route('periode.destroy',[$periode,$category[0]->id]) }}');">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>