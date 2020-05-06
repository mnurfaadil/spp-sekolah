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
        <th>Metode</th>
        <th>Keterangan</th>
    </tr>
@php
$total = [0,0,0];
@endphp
@foreach($datas as $data)
@php
  $tunggakan = intval($data->akumulasi)-intval($data->terbayar);
  if($tunggakan!=0){
    $besaran = intval($data->akumulasi);
    $terbayar = intval(($data->terbayar!=0)?$data->terbayar:0);
    $sisa = $besaran - $terbayar;
    $total[0] += $besaran;
    $total[1] += $terbayar;
    $total[2] += $sisa;
  }
  
@endphp
  @if($tunggakan!=0)
    <tr>
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$data->nama}}</td>
        <td>{{$data->kelas}}&nbsp;-&nbsp;{{$data->jurusan}}</td>
        <td style="text-align:right">{{number_format($data->akumulasi,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($data->terbayar,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($tunggakan,0,',','.')}}</td>
        <td>{{$data->metode}}</td>
        <td>Nunggak</td>
    </tr>
  @endif
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total </span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
