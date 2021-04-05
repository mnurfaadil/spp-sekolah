
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <style>
    .page_break { page-break-before: always; },

    .garis_dua{ 
      border: 0;
      border-top: 5px double #8c8c8c;
    }

    .table1 {
        font-family: serif;
        font-size: 9pt;
        color: #444;
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #f2f5f7;
    }
    
    .table1 tr th{
        background: #35A9DB;
        color: #fff;
        font-weight: normal;
    }
    
    .table1, th, td {
        padding: 8px 20px;
        text-align: center;
    }
    
    .table1 tr:hover {
        background-color: #f5f5f5;
    }
    
    .table1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div >
        <div style="float:left;padding-right:20px;">
        <br>
          <!-- <img style="hight:70; width:70;" src="{{asset('assets/img/logo/bbl.png')}}" /> -->
          <!-- <img style="hight:70; width:70;" src="{{public_path('assets\img\logo\bbl.png')}}" /> -->
        </div>
        <div style="padding-top:10">
          <p> <span style="font-size:14pt;font-style:bold">SMK BAABUL KAMIL</span>
          <br> <span style="font-size:12pt">Terakreditasi 'A' | Program Keahlian : Multimedia, Adm Perkantoran & Perawatan</span>
          <br> <span style="font-size:10pt">Alamat:Jl. Cikuda No. 08 Jatinangor, Tlp : (022) 7797312 / 085294124866</span>
          <br> <span style="font-size:10pt">Email: <span style="color:blue; font-style: italic;"> smkbaabulkamil_jatinangor@yahoo.com </span></span>
          | <span style="font-size:10pt">Website : <span style="color:blue;font-style: italic;">www.smkbaabulkamil.sch.id</span></span>
          </p>
        </div>
      </div>
        <hr class="garis_dua">
        <center><h4>{{$title}}</h4></center>
        @if ($jur!='' || $kls!='')
          <table >
          @if($kls=='' && $jur!=''){
            <tr>
              <td>Jurusan</td>
              <td>:</td>
              <td style='text-align:left'>{{$majors->nama}}</td>
            </tr>
          @elseif ($jur=='' && $kls!='') {
            <tr>
              <td>Kelas</td>
              <td>:</td>
              <td style='text-align:left'>{{$kls}}</td>
            </tr>
          @else
            <tr>
              <td>Kelas</td>
              <td>:</td>
              <td style='text-align:left'>{{$kls}}</td>
            </tr>
            <tr>
              <td>Jurusan</td>
              <td>:</td>
              <td style='text-align:left'>{{$majors->nama}}</td>
            </tr>
          @endif
        </table>
        @endif
        <table class="table1">
          <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>L/P</th>
            <th>Angkatan</th>
            <th>No Telp</th>
            <th>Alamat</th>
          </tr>
          @foreach($students as $data)
          <tr>
            <td>{{$no++}}</td>
            <td>{{$data->nis}}</td>
            <td>{{$data->nama}}</td>
            <td>{{$data->jenis_kelamin}}</td>
            <td>{{$data->angkatan}} - {{$data->tahun}}</td>
            <td>{{$data->phone}}</td>
            <td>{{$data->alamat}}</td>
          </tr>
          @endforeach
        </table>	
  </body>
</html>