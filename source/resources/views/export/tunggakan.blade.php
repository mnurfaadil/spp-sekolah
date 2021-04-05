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
        <th>Biaya per Bulan</th>
        <th>Tunggakan</th>
        <th>Besar Tunggakan</th>
    </tr>
@php
$total = [0,0,0,0];
@endphp
@foreach($datas as $data)
@php
  $nominal = intval($data->nominal);
  $besaran = $data->banyak_tunggakan * $nominal;
  $total[0] += $nominal;
  $total[1] += intval($data->banyak_tunggakan);
  $total[2] += $besaran;
@endphp
  <tr>
      <td>{{$no++}}</td>
      <td style="text-align:left;">{{$data->nama}}</td>
      <td>{{$data->kelas}}&nbsp;-&nbsp;{{$data->inisial}}</td>
      <td style="text-align:right">{{number_format($nominal,0,',','.')}}</td>
      <td>{{$data->banyak_tunggakan}} Bulan </td>
      <td style="text-align:right">{{number_format($besaran,0,',','.')}}</td>
  </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total </span></th>
        <th class="footer-right"  style="font-size:12pt;">{{number_format($total[0],0,',','.')}}</th>
        <th class="footer-right" style="font-size:12pt;">{{$total[1]}} Bulan</th>
        <th class="footer-right"  style="font-size:12pt;">{{number_format($total[2],0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
