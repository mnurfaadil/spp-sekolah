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
    $url="";
    $total =$total + intval($data->debit);
    if(isset($data->pemasukan)){
        $url = "nota/{$data->pemasukan->foto}";
        $url = asset('').$url;
    }
    $temp = strtotime($data->created_at);
    $tanggal = date('j - M - Y', $temp); 
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td>
            @if(isset($data->pemasukan))
            <img style="height:70; width:70;" src="{{$url}}" alt="Foto Bukti"/>
            @else
            &nbsp;
            @endif
        </td>
        <td style="text-align:left;">{{$tanggal}} </td>
        <td style="text-align:left;word-wrap:break-word;">{{$data->description}}</td>
        <td style="text-align:right">{{number_format($data->debit,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="4" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total,0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
