<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rincian</title>
    <style>
    .text-atas tr td{
      font-size: 6pt;
    }
.page_break { page-break-before: always; },
.garis_dua{ 
  border: 0;
  border-top: 5px double #8c8c8c;
}
*{
  margin:0;
}
</style>
  </head>
  <body width="100%">
    <div style="border-style: solid;margin:3px">
    <header class="clearfix">
      
      <div style="padding-top:3px;">
        <div style="float:left;padding-right:3px;padding-left:3px;">
          <!-- <img style="hight:20; width:20;" src="{{public_path('assets\img\logo\bbl.png')}}" /> -->
          <!-- <img style="hight:20; width:20;" src="{{asset('assets/img/logo/bbl.png')}}" /> -->
        </div>
        <div style="padding-left:3px;padding-bottom:3px;">
          <p> <span style="font-size:6pt;font-style:bold">SMK BAABUL KAMIL</span></p>
          <p><span style="font-size:6pt">Terakreditasi 'A' | Program Keahlian : Multimedia, Adm Perkantoran & Perawatan</span></p>
          <p><span style="font-size:6pt">Alamat:Jl. Cikuda No. 08 Jatinangor, Tlp : (022) 7797312 / 083294124866</span></p>
          <p><span style="font-size:6pt">Email: <span style="color:blue; font-style: italic;"> smkbaabulkamil_jatinangor@yahoo.com </span> | Website : <span style="color:blue;font-style: italic;">www.smkbaabulkamil.sch.id</span></span></p>
          </p>
        </div>
      </div>
        <hr class="garis_dua">
        <center><p style="font-size:6pt;font-style:bold">BUKTI PEMBAYARAN SISWA</p></center><hr>
        <table style="font-size:6pt" width='100%'>
          <tr>
            <td width='50%'>
              <table width="100%" class="text-atas">
                <tr>
                  <td>DICETAK</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>  
                <tr>
                  <td>TANGGAL</td>
                  <td>:</td>
                  <td>{{$data['tanggal']}}</td>
                </tr>  
                <tr>
                  <td>WAKTU</td>
                  <td>:</td>
                  <td>{{$data['waktu']}}</td>
                </tr>  
              </table>
            </td>
            <td width='50%'>
            <table width="100%" style="font-size:6pt" class="text-atas">
                <tr>
                  <td>NIS</td>
                  <td>:</td>
                  <td>{{$siswa['nis']}}</td>
                </tr>  
                <tr>
                  <td>NAMA</td>
                  <td>:</td>
                  <td>{{$siswa['nama']}}</td>
                </tr>  
                <tr>
                  <td>KELAS</td>
                  <td>:</td>
                  <td>{{$siswa['kelas']}} - {{$siswa['major']->nama}}</td>
                </tr>  
              </table>
            </td>
          </tr>
        </table>
    </header>
    <hr>
    <main style="align-item:center;">
      <table style="font-size:6pt" width="100%">
        <thead>
          <tr>
            <th width="15%">NO</th>
            <th width="65%">DESKRIPSI</th>
            <th width="20%">JUMLAH</th>
          </tr>
        </thead>
        <tbody>
        <tr>
          <td colspan="3"><hr></td>
          </tr>
          <tr>
            <td >
            <div style="text-align:center">
            {{$no}}
            </div>
            </td>
            <td >
              <div style="word-wrap: break-word;">
              {{$data['desc']}}
              </div>
            <td class="unit">
              <div style="text-align:right">
              {{number_format($data['nominal'],0,',','.')}}
              </div>
            </td>
          </tr>
          <tr>
          <td colspan="3"><hr></td>
          </tr>
        </tbody>
      </table>
      <table style="font-size:6pt" width='100%'>
          <tr>
            <td width='50%'>
              <table>
                <tr>
                  <td>&nbsp;</td>
                </tr> 
                <tr>
                <td>&nbsp;</td>
                </tr>
              </table>
            </td>
            <td width='50%'>
            <table width='100%'>
              <tr>
                <td><strong>Total :</strong></td>
                <td style="text-align:right"><strong>
              {{number_format($data['nominal'],0,',','.')}}</strong></td>
                </tr> 
                <tr>
                  <td colspan='2'><hr></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
    </main>
    <footer>
    <table style="font-size:6pt" width='100%'>
      <tr>
        <td width='50%'>
          <table width='100%'>
            <tr></tr>
          </table>
        </td>
        <td width='50%'>
          <table style="font-size:6pt" style="text-align:center" width='100%'>
            <tr>
              <td>Jatinangor, {{$data['tanggal']}}</td>
            </tr>
            <tr>
            <td>Bendahara Sekolah</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table style="font-size:6pt" width='100%'>
      <tr>
        <td width='50%'>
          <table width='100%'>
            <tr>
              <td>Catatan</td>
            </tr>
            <tr style='font-size:3px'>
              <td style='font-size:6pt'>- Disimpan sebagai pembayaran bukti yang SAH</td>
            </tr>
            <tr style='font-size:3px'>
              <td style='font-size:6pt'>- Uang yang dibayar tidak dapat diminta kembali</td>
            </tr>
          </table>
        </td>
        <td width='50%'>
          <table style="font-size:6pt" width='100%'>
            <tr><td><br></td></tr>
            <tr>
              <td style="text-align:center;font-size:7pt"><span style="text-decoration: underline; font-weight:bold"> {{$user}} </span></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    </footer>
    </div>
  </body>
</html>