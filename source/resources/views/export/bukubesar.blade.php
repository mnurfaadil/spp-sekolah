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
        <th>Debit</th>
        <th>Kredit</th>
        <th>Saldo</th>
    </tr>
@php
$total = 0;
$saldo = 0;
$total_kredit = 0;
$total_debit = 0;
@endphp
@foreach($datas as $data)
@php
    $total_debit += $data->debit;
    $total_kredit += $data->kredit;
    $saldo = $saldo + $data->debit - $data->kredit;
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$data->created_at}}</td>
        <td style="text-align:left;word-wrap:break-word;">{{$data->description}}</td>
        <td style="text-align:right">{{number_format($data->debit,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($data->kredit,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($saldo,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:18px;font-weight:bold;">{{number_format($total_debit,0,',','.')}}</th>
        <th style="text-align:right;font-size:18px;font-weight:bold;">{{number_format($total_kredit,0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($saldo,0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
