@extends('export.layout.landscape')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
<table class="table1" style="table-layout:fixed;">
    <tr>
        <th style="width:5%">No</th>
        <th style="width:25%">Foto</th>
        <th style="width:20%">Tanggal</th>
        <th style="width:45%">Deskripsi</th>
        <th style="width:15%">Nominal</th>
    </tr>
@php
$total = 0;
@endphp
@foreach($datas as $data)
@php
    $total =$total + intval($data->kredit); 
    $url = "nota/{$data->foto}";
    $url = asset('').$url;
    $temp = strtotime($data->created_at);
    $tanggal = date('j - M - Y', $temp); 
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td>
            @if($data->tipe=="img")
            <img style="height:70; width:70;" src="{{$url}}" alt="Foto Bukti"/>
            @else
            &nbsp;
            {{$data->tipe}}
            @endif
        </td>
        <td style="text-align:left;">{{$tanggal}}</td>
        <td style="text-align:left;word-wrap:break-word;">{{$data->description}}</td>
        <td style="text-align:right">{{number_format($data->kredit,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="4" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total,0,',','.')}}</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
