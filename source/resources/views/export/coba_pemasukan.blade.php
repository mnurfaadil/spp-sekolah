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
        <th>Tanggal</th>
        <th>Deskripsi</th>
        <th>Nominal</th>
        <th>Saldo</th>
    </tr>
@php
$no = 1;
$total = 0;
$saldo = 0;
$nominal = 0;
@endphp
@foreach($datas as $data)
@php
    $nominal += $data->nominal;
    $saldo = $saldo + $data->nominal;
    $temp = strtotime($data->created_at);
    $tanggal = date('j - M - Y', $temp);
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td style="text-align:left;white-space: nowrap;">{{$tanggal}}</td>
        <td style="text-align:left;word-wrap:break-word;">{{ $data->description }}</td>
        <td style="text-align:right">{{number_format($data->nominal,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($saldo,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:18px;font-weight:bold;">{{number_format($nominal,0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($saldo,0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
