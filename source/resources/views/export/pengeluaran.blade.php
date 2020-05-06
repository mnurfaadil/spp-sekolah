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
    $url=null;
    $total =$total + intval($data->kredit); 
    if(isset($data->pengeluaran)){
        $url = "nota/".$data->pengeluaran->foto;
        $url = asset('').$url;
    } 
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td>
            @if($url)
            <img style="height:70; width:70;" src="{{$url}}" alt="Foto Bukti"/>
            @else
            &nbsp;
            @endif
        </td>
        <td style="text-align:left;">{{$url}}</td>
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
