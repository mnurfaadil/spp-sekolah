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
        <th >Keterangan</th>
    </tr>
@php
    $total = [0,0,0,0];
@endphp
    @foreach($datas as $data)
        @php
        //Main
            $persentase = $data->persentase;
            $_besaran = intval($data->nominal);
            $_persentase = intval($data->persentase);
            $_nominal_potongan = intval($data->nominal_potongan);

            //Besaran
            $besaran = number_format($_besaran,0,',','.');

            //Persentase
            //Potongan
            if ($data->jenis_potongan != "persentase") {
                $_persentase = ($_nominal_potongan/$_besaran)*100;
            }
            else
            {
                $_nominal_potongan = $_besaran * ($persentase / 100);    
            }
            $persentase = number_format($_persentase,0,',','.');
            $potongan = number_format($_nominal_potongan,0,',','.');
            
            //Terbayar
            $_terbayar = intval($data->cicilan);
            $terbayar = number_format($_terbayar,0,',','.');
            
            //Sisa
            $_sisa = $_besaran - $_nominal_potongan - $_terbayar;
            $sisa = number_format($_sisa,0,',','.');
            
            //Status
            if( $data->jenis_pembayaran=="Waiting")
            {
                $status = 'Waiting';
            }
            else if($data->jenis_pembayaran=="Nunggak")
            {
                $status = 'Nunggak';
            }
            else if($data->jenis_pembayaran=="Cicilan" && $_sisa != 0)
            {
                $status = 'Belum Lunas';
            }
            else
            {
                $status = 'Lunas';
            }

        @endphp
        @php
            $total[0] += $_besaran;
            $total[1] += $_nominal_potongan;
            $total[2] += $_terbayar;
            $total[3] += $_sisa;
        @endphp
    <tr class="table-content">
        <td>{{$no++}}</td>
        <td style="text-align:left;">{{$data->nama}}</td>
        <td>{{$data->kelas}}&nbsp;-&nbsp;{{$data->jurusan}}</td>
        <td style="text-align:right">{{$besaran}}</td>
        <td style="text-align:right">{{$potongan}}</td>
        <td style="text-align:right">{{$terbayar}}</td>
        <td style="text-align:right">{{$sisa}}</td>
        <td style="text-align:center">{{ $status }}</td>
    </tr>
@endforeach
    <tr class="footer-section">
        <th colspan="3" style="text-align:right"><span style="font-size:20px;font-weight:bold;">Total :</span></th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[0],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[1],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[2],0,',','.')}}</th>
        <th style="text-align:right;font-size:20px;font-weight:bold;">{{number_format($total[3],0,',','.')}}</th>
        <th class="footer-right">&nbsp;</th>
    </tr>
</table>
<small><span style="font-style:italic">Dicetak pada {{now()}}</span></small>
@endsection
