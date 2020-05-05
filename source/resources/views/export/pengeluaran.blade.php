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
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td>
            <img style="height:70; width:70;" src="C:\Users\Fadil\Documents\programming\GitRobi\spp-sekolah-server\nota\3aa7619c-8d0b-11ea-9aa2-025b510638641588488995_photo6102464760688781872.jpg" />
        </td>
        <td style="text-align:left;">{{$data->created_at}} </td>
        <td style="text-align:left;word-wrap:break-word;">{{$data->description}} aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td>
        <td style="text-align:right">{{number_format($data->kredit,0,',','.')}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="4" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total,0,',','.')}}</th>
    </tr>
</table>
<small>Dibuat pada {{now()}}</small>
@endsection
