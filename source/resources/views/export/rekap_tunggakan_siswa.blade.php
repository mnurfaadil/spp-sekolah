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
        $i = -1;
        $d = $datas->count();
        $total = [0,0,0,0];
        $total_perorang = [0,0,0,0];
    @endphp
    @foreach($datas as $data)
    @php
        $i++;
        
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
        
        $cek = false;
        $cek2 = false;

        $total_perorang[0] += (int) $besaran;
        $total_perorang[1] += (int) $potongan;
        $total_perorang[2] += (int) $terbayar;
        $total_perorang[3] += (int) $sisa;
            

        try {            
            if ($datas[$i+1]) {
                $cek = true;
                if ($datas[$i]->nama_murid != $datas[$i+1]->nama_murid) {
                    $cek2 = true;
                }
            }
        } catch (Exception $e) {
            // exception is raised and it'll be handled here
            // $e->getMessage() contains the error message
        }

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
    @if ($cek2 || $d == ( $i+1 ))
        <tr>
            <td colspan="6"> <div style="font-weight:bold; color:red;">Tunggakan {{$data->nama_murid}} : </div> </td>
            <td ><div style="text-align:right;font-weight:bold; color:red;">{{number_format($total_perorang[0],0,',','.')}}</div></td>
            <td ><div style="text-align:right;font-weight:bold; color:red;">{{number_format($total_perorang[1],0,',','.')}}</div></td>
            <td ><div style="text-align:right;font-weight:bold; color:red;">{{number_format($total_perorang[2],0,',','.')}}</div></td>
            <td ><div style="text-align:right;font-weight:bold; color:red;">{{number_format($total_perorang[3],0,',','.')}}</div></td>
        </tr>
    @endif
    @php
        if ($cek2) {
            $total_perorang = [0,0,0,0];
        }
    @endphp
    @endforeach
    <tr >
        <th colspan="6" style="text-align:center;"><span style="font-size:12pt;font-weight:bold;">Total </span></th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th style="text-align:right;font-size:12pt;font-weight:bold;">{{number_format($total[3],0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
