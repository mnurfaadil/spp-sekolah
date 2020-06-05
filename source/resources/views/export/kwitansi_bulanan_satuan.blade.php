
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rincian</title>
    <style>
    .text-atas tr td{
      font-size: 5pt;
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
    <div style="border-style: solid;margin:10px">
    <header class="clearfix">
      
      <div style="padding-top:10px;">
        <div style="float:left;padding-right:10px;padding-left:10px;">
          <img style="hight:30; width:30;" src="{{asset('assets/img/logo/bbl.png')}}" />
        </div>
        <div style="padding-top:5;padding-left:10px;">
          <p> <span style="font-size:8pt;font-style:bold">SMK BAABUL KAMIL</span>
          <br> <span style="font-size:6pt">Terakreditasi 'A' | Program Keahlian : Multimedia, Adm Perkantoran & Perawatan</span>
          <br> <span style="font-size:5pt">Alamat:Jl. Cikuda No. 08 Jatinangor, Tlp : (022) 7797312 / 085294124866</span>
          <br> <span style="font-size:5pt">Email: <span style="color:blue; font-style: italic;"> smkbaabulkamil_jatinangor@yahoo.com </span></span>
          | <span style="font-size:5pt">Website : <span style="color:blue;font-style: italic;">www.smkbaabulkamil.sch.id</span></span>
          </p>
        </div>
      </div>
        <hr class="garis_dua">
        <center><p style="font-size:8pt;font-style:bold">BUKTI PEMBAYARAN SISWA</p></center><hr>
        <table width='100%'>
          <tr>
            <td width='50%'>
              <table class="text-atas">
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
            <table class="text-atas">
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
      <table style="font-size:5pt;" width="100%">
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
              {{number_format($data['periode']->nominal,0,',','.')}}
              </div>
            </td>
          </tr>
          <tr>
          <td colspan="3"><hr></td>
          </tr>
        </tbody>
      </table>
      <table width='100%'>
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
            <table style='font-size:5pt' width='100%'>
              <tr>
                <td><strong>Total :</strong></td>
                <td style="text-align:right"><strong>
              {{number_format($data['periode']->nominal,0,',','.')}}</strong></td>
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
    <table width='100%'>
      <tr>
        <td width='50%'>
          <table width='100%'>
            <tr></tr>
          </table>
        </td>
        <td width='50%'>
          <table style="text-align:center;font-size:5pt" width='100%'>
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
    <table width='100%'>
      <tr>
        <td width='50%'>
          <table style='font-size:5pt' width='100%'>
            <tr>
              <td>Catatan</td>
            </tr>
            <tr style='font-size:5pt'>
              <td>- Disimpan sebagai pembayaran bukti yang SAH</td>
            </tr>
            <tr style='font-size:5pt'>
              <td>- Uang yang dibayar tidak dapat diminta kembali</td>
            </tr>
          </table>
        </td>
        <td width='50%'>
          <table width='100%'>
            <tr><td><br></td></tr>
            <tr>
              <td style="text-align:center;font-size:6pt"><span style="text-decoration: underline; font-weight:bold"> {{$user}} </span></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    </footer>
    </div>
  </body>
</html>