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
        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Akumulasi Biaya</th>
        <th>Terbayar</th>
        <th>Sisa Pembayaran</th>
        <th>Tunggakan</th>
    </tr>
@php
$total = [0,0,0,0];
@endphp
@foreach($datas as $data)
@php
    $detail = intval($data->detail->count());
    $detail_nunggak = $data->detail->where('jenis_pembayaran','Nunggak')->count();
    $nominal = intval($data->periode->first()->nominal);
    $besaran = $detail*$nominal;
    $terbayar = intval(($data->detail->sum('nominal')!=0)?$data->detail->sum('nominal'):0);
    $sisa = $besaran - $terbayar;
    $detail_nunggak = $data->detail->where('status','Nunggak')->count();

    $total[0] += $besaran;
    $total[1] += $terbayar;
    $total[2] += $sisa;
    $total[3] += intval($detail_nunggak);
@endphp
    <tr class="row-content">
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$data->student->nama}}</td>
        <td>{{$data->student->kelas}}&nbsp;-&nbsp;{{$data->student->major->inisial}}</td>
        <td style="text-align:right">{{number_format($besaran,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($terbayar,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($sisa,0,',','.')}}</td>
        <td>{{$detail_nunggak}} Bulan</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total </span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th class="footer-right">{{$total[3]}} Bulan</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
