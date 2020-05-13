@extends('export.layout.landscape')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
<table class="table1 table-content" style="margin-left: -20px">
    <tr>
        <th>No</th> 
        <th>Nama</th>
        <th>Kelas</th>
        <th>Total</th>
        <th>Potongan</th>
        <th>Terbayar</th>
        <th>Sisa</th>
        <th>Keterangan</th>
    </tr>
@php
$total = [0,0,0,0];
@endphp
@foreach($datas as $k)
@php
  $detail = $k->detail->first();
  $nominal = intval($detail->periode->nominal);
  $terbayar = intval($detail->cicilan->sum('nominal'));
  $potongan  = intval($k->persentase)*$nominal/100;
  $sisa = $nominal - ($terbayar + $potongan);
  $total[0] += $nominal;
  $total[1] += $potongan;
  $total[2] += $terbayar;
  $total[3] += $sisa;
  if($k->jenis_pembayaran=="Waiting"){
    $keterangan = "Unconfirmed";
  }elseif($k->jenis_pembayaran=="Cicilan"){
    $keterangan = "Cicilan";
  }else{
    $keterangan = "Nunggak";
  }
@endphp
    <tr>
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$k->student->nama}}</td>
        <td>{{$k->student->kelas}}&nbsp;-&nbsp;{{$k->student->major->inisial}}</td>
        <td style="text-align:right">{{number_format($nominal,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($potongan,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($terbayar,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($sisa,0,',','.')}}</td>
        <td>{{$keterangan}}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:center"><span style="font-size:20px;font-weight:bold;">Total </span></th>
        <th style="text-align:right;font-size:16pt;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:16pt;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:16pt;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th style="text-align:right;font-size:16pt;font-weight:bold;">{{number_format($total[3],0,',','.')}}</th>
        <th>&nbsp;</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
