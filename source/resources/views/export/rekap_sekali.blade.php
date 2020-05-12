@extends('export.layout.landscape')

@section('title-html')
{{$title}}
@endsection

@section('title')
{{$title}}
@endsection

@section('content')
<table class="table1" style="margin-left:-10px">
    <tr>
        <th >No</th>
        <th >Nama</th>
        <th >Kelas</th>
        <th >Besaran</th>
        <th >Potongan</th>
        <th >Terbayar</th>
        <th >Sisa</th>
        <th >Metode</th>
        <th >Keterangan</th>
    </tr>
@php
    $total = [0,0,0,0];
@endphp
    @foreach($datas as $data)
        @php
            $besaran = intval($data->detail->first()->periode->nominal);
            $potongan = floor($besaran*intval($data->persentase)/100);
            $terbayar = intval($data->detail->first()->cicilan->sum('nominal'));
            $sisa = $besaran - ($potongan + $terbayar);
        @endphp
        @php
            $total[0] += $besaran;
            $total[1] += $potongan;
            $total[2] += $terbayar;
            $total[3] += $sisa;
        @endphp
    <tr class="table-content">
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$data->student->nama}}</td>
        <td>{{$data->student->kelas}}&nbsp;-&nbsp;{{$data->student->major->inisial}}</td>
        <td style="text-align:right">{{number_format($besaran,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($potongan,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($terbayar,0,',','.')}}</td>
        <td style="text-align:right">{{number_format($sisa,0,',','.')}}</td>
        <td>{{$data->jenis_pembayaran}}</td>
        <td>
            @if($sisa==0 && ($data->jenis_pembayaran == "Cicilan" || $data->jenis_pembayaran == "Tunai"))
                Lunas
            @elseif($data->terbayar != 0)
                Belum Lunas
            @elseif($data->jenis_pembayaran == "Nunggak")
                Nunggak
            @elseif($data->jenis_pembayaran == "Cicilan")
                Cicilan
            @else
                Waiting
            @endif
        </td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[3],0,',','.')}}</th>
        <th class="footer-right">&nbsp;</th>
        <th class="footer-right">&nbsp;</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
