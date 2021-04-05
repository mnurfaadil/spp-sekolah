@extends('export.layout.landscape')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
<table class="table1">
    <thead>
        <th data-field="no"><div style="text-align:center;">No</div></th>
        <th data-field="tanggal"><div style="text-align:center;">Nama</div></th>
        <th data-field="kategori"><div style="text-align:center;">Kategori</div></th>
        <th data-field="deskripsi"><div style="text-align:center;">Kelas</div></th>
        <th data-field="jurusan"><div style="text-align:center;">Jurusan</div></th>
        <th data-field="angkatan"><div style="text-align:center;">Angkatan</div></th>
        <th data-field="besaran"><div style="text-align:center;">Besaran</div></th>
        <th data-field="potongan"><div style="text-align:center;">Potongan</div></th>
        <th data-field="terbayar"><div style="text-align:center;">Terbayar</div></th>
        <th data-field="sisa"><div style="text-align:center;">Sisa</div></th>
    </thead>
    @php
    $no = 1;
    $total = [0,0,0,0];
    $rowTotal = [0,0,0,0];
    $tData = $datas[0];
    $stat = false;
    @endphp
    @foreach($datas as $i => $data)
    @php
        if ($data->jenis_kategori == "Bayar per Bulan") {
            $kelas_x = $data->kelas_x;
            $kelas_xi = $data->kelas_xi;
            $kelas_xii = $data->kelas_xii;
            $besaran = $kelas_x*12 + $kelas_xi*12 + $kelas_xii*12;
            $potongan = 0;
            $terbayar = $data->nominal_detail;
        }
        else
        {
            $besaran = $data->nominal;
            if ( $data->jenis_potongan == "persentase")
            {
                $potongan = (intval($data->persentase) / 100) * $besaran;
            }
            else
            {
                $potongan = intval($data->nominal_potongan);
            }
            $terbayar = $data->nominal_cicilan;
        }
        $sisa = $besaran - ($potongan + $terbayar);
        if ($sisa != 0) {
            $total[0] += (int) $besaran;
            $total[1] += (int) $potongan;
            $total[2] += (int) $terbayar;
            $total[3] += (int) $sisa;
            
            $rowTotal[0] += (int) $besaran;
            $rowTotal[1] += (int) $potongan;
            $rowTotal[2] += (int) $terbayar;
            $rowTotal[3] += (int) $sisa;
            if($i==0 || $data->student_id == $tData->student_id ) {
                
                $stat = false;
                if(isset($datas[$i+1]) && $datas[$i+1]->student_id != $tData->student_id){
                    $stat = true;
                }
                
            }else{
                $stat = true;
                $tData = $datas[$i];
            }
        }
    @endphp
        
        @if($sisa != 0)
        <tr>
            <td>{{$no++}}</td>
            <td >{{$data->nama_murid}}</td>
            <td ><div style="text-align:center;">{{$data->nama_kategori}}</div></td>
            <td ><div style="text-align:center;">{{$data->kelas}}</div></td>
            <td ><div style="text-align:center;">{{$data->inisial}}</div></td>
            <td ><div style="text-align:center;">{{$data->angkatan}} ({{$data->tahun_angkatan}})</div></td>
            <td ><div style="text-align:right;">{{number_format($besaran,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($potongan,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($terbayar,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($sisa,0,',','.')}}</div></td>
        </tr>
        @if($stat)
        <tr class="footer-section">
            <th colspan="6" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total Tunggakan Siswa </span></th>
            <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($rowTotal[0],0,',','.')}}</th>
            <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($rowTotal[1],0,',','.')}}</th>
            <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($rowTotal[2],0,',','.')}}</th>
            <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($rowTotal[3],0,',','.')}}</th>
            <th>&nbsp;</th>
        </tr>
        @php
            $rowTotal = [0,0,0,0];
        @endphp
        @endif
        @endif
    @endforeach
    <tr class="footer-section">
        <th colspan="6" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total </span></th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[3],0,',','.')}}</th>
        <th>&nbsp;</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>


@endsection

@push('custom-style')
    <style>
        @media print {
            @page {size: landscape}
            
            body {
                margin: 0;
                color: #000;
                background-color: #fff;
            }
            .page_break { page-break-before: always; }

            .garis_dua{ 
                border: 0;
                border-top: 5px double #8c8c8c;
            }

            .table1 {
                font-family: serif;
                font-size: 11pt;
                color: #444;
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #f2f5f7;
            }
            
            .table1 tr th{
                /* background: #35A9DB; */
                font-weight: bold;
                color: black;
            }

            .table1 tr td{
                font-size:10pt;
            }

            .table1 tr th .footer-right{
                background-color: #F0FFFF;
                font-weight: bold;
                font-size:10pt;
                text-align:right;
                color: black;
            }
            
            .page { width: 100%; height: 100%; }

            .table1, th, td {
                padding: 8px 14px;
                text-align: center;
                font-size: 12pt;
            }
            
            .table1 tr:hover {
                background-color: #f5f5f5;
            }
            
            .table1 tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .table-content tr td{
            font-size: 10pt;
            }
            .row-content td{
            font-size: 10pt;
            }

            .table1 .footer-section {

            }

        }
    </style>
@endpush

@push('scripts')
    <script>
    window.addEventListener("load", window.print());
  </script>
@endpush