@extends('export.layout.landscape')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
<table class="table1">
    <tr>
        <th data-field="no"><div style="text-align:center;">No</div></th>
        <th data-field="tanggal"><div style="text-align:center;">Nama</div></th>
        <th data-field="deskripsi"><div style="text-align:center;">Kelas</div></th>
        <th data-field="jurusan"><div style="text-align:center;">Jurusan</div></th>
        <th data-field="angkatan"><div style="text-align:center;">Angkatan</div></th>
        <th data-field="kategori"><div style="text-align:center;">Kategori</div></th>
        <th data-field="besaran"><div style="text-align:center;">Besaran</div></th>
        <th data-field="potongan"><div style="text-align:center;">Potongan</div></th>
        <th data-field="terbayar"><div style="text-align:center;">Terbayar</div></th>
        <th data-field="sisa"><div style="text-align:center;">Sisa</div></th>
    </tr>
    @php
        $total = [0,0,0,0];
    @endphp
    @foreach($datas as $data)
    @php
        $bulan_spp = 36;
        if ($data->nama == 'SPP')
        {
            $besaran = $bulan_spp * (int) $data->nominal;
            $terbayar = ($bulan_spp - (int) $data->banyak_tunggakan) * (int)$data->nominal;
            $potongan = 0;
        }
        else
        {
            $besaran = (int) $data->nominal;
            $terbayar = $data->cicilan_dibayar == null ? 0 : (int) $data->cicilan_dibayar;
            $potongan = (int) (((int)$data->persentase * (int) $data->nominal)/100);
        }
        $sisa = $besaran - ( $terbayar + $potongan );
        
        $total[0] += (int) $besaran;
        $total[1] += (int) $potongan;
        $total[2] += (int) $terbayar;
        $total[3] += (int) $sisa;
    @endphp
        <tr>
            <td>{{$no++}}</td>
            <td >{{$data->nama_murid}}</td>
            <td ><div style="text-align:center;">{{$data->kelas}}</div></td>
            <td ><div style="text-align:center;">{{$data->inisial}}</div></td>
            <td ><div style="text-align:center;">{{$data->angkatan}} ({{$data->tahun_angkatan}})</div></td>
            <td ><div style="text-align:center;">{{$data->nama}}</div></td>
            <td ><div style="text-align:right;">{{number_format($besaran,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($potongan,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($terbayar,0,',','.')}}</div></td>
            <td ><div style="text-align:right;">{{number_format($sisa,0,',','.')}}</div></td>
        </tr>
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
