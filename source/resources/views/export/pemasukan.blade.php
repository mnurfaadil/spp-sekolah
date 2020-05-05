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
        <th>Foto</th>
        <th>Tanggal</th>
        <th>Deskripsi</th>
        <th>Nominal</th>
    </tr>
@php
$total = 0;
@endphp
@foreach($datas as $data)
@php
    $total =$total + intval($data->debit);
    
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td>
            <img style="height:70; width:70;" src="{{public_path('')}}\assets\img\logo\bbl.png" alt="Foto Bukti"/>
        </td>
        <td style="text-align:left;">{{$data->created_at}} </td>
        <td style="text-align:left;word-wrap:break-word;">{{$data->description}}</td>
        <td style="text-align:right">{{number_format($data->debit,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="4" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total,0,',','.')}}</th>
    </tr>
</table>
<small>Dibuat pada {{now()}}</small>
@endsection
