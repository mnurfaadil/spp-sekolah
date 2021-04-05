
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pembayaran Hari Ini</title>
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
          <img style="hight:70; width:70;" src="{{asset('assets/img/logo/bbl.png')}}" />
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
        <center><h4>Pembayaran Hari Ini</h4></center>
          <table width="100%" style="font-family: serif; font-size: 9pt;">
            <tr>
              <td>
                <table>
                  <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td style='text-align:left'>{{$datas[0]}}</td>
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td style='text-align:left'>{{$datas[1]}}</td>
                  </tr>
                </table>  
              </td>
              <td>
                <table>
                  <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td style='text-align:left'>{{$datas[2]}}</td>
                  </tr>
                  <tr>
                    <td>Angkatan</td>
                    <td>:</td>
                    <td style='text-align:left'>{{$datas[3]}}</td>
                  </tr>
                </table>
              </td>
            </tr>
        </table>
        <table class="table1">
          <tr>
            <th>No</th>
            <th>Waktu Pembayaran</th>
            <th>Deskripsi</th>
            <th>Nominal (Rp)</th>
          </tr>
          @php 
            $total = 0;
            $idx = 0;
          @endphp
          @foreach($bigDatas as $dt)
            @php 
              $idx++; 
              $total = $total +  $dt->nominal ;
            @endphp
          <tr>
            <td>{{$no++}}</td>
            <td>{{$dt->created_at}}</td>
            <td>{{$dt->title}}</td>
            <td><div style="text-align: right;">{{number_format($dt->nominal,0,',','.')}}</div></td>
          </tr>
          @endforeach
          <tr>
              <th colspan="3">
                  <div style="text-align: center;">Jumlah</div>
              </th>
              <th>
                  <div style="text-align: right;">{{number_format($total,0,',','.')}}</div>
              </th>
          </tr>
        </table>	
  </body>
</html>