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
          @for($i = 0; $i < 30; $i++)
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
          @endfor
        </tbody>
    </table>
</div>