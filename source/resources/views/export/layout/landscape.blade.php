
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>@yield('title-html')</title>
    <style>
    .page_break { page-break-before: always; }

    .garis_dua{ 
      border: 0;
      border-top: 5px double #8c8c8c;
    }

    .table1 {
        font-family: serif;
        font-size: 11pt;
        color: #444;
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #f2f5f7;
    }
    
    .table1 tr th{
        background: #35A9DB;
        font-weight: bold;
        color: black;
    }

    .table1 tr td{
        font-size:10pt;
    }

    .table1 tr th .footer-right{
        background-color: #F0FFFF;
        font-weight: bold;
        font-size:10pt;
        text-align:right;
        color: black;
    }
    
    .page { width: 100%; height: 100%; }

    .table1, th, td {
        padding: 8px 14px;
        text-align: center;
        font-size: 12pt;
    }
    
    .table1 tr:hover {
        background-color: #f5f5f5;
    }
    
    .table1 tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .table-content tr td{
      font-size: 10pt;
    }
    .row-content td{
      font-size: 10pt;
    }

    .table1 .footer-section {

    }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div >
        <div style="float:left;padding-right:20px;">
          <img style="height:70px; width:70px; margin: 5px;" src="{{asset('assets/img/logo/bbl.png')}}"/>
          <!-- <img style="height:70; width:70;" src="{{public_path('assets\img\logo\bbl.png')}}"/> -->
        </div>
        <div style="padding-top:10">
          <p> <span style="font-size:14pt;font-style:bold">SMK BAABUL KAMIL</span>
          <br> <span style="font-size:12pt">Terakreditasi 'A' | Program Keahlian : Multimedia, Adm Perkantoran & Perawatan</span>
          <br> <span style="font-size:10pt">Alamat:Jl. Cikuda No. 08 Jatinangor, Tlp : (022) 7797312 / 085294124866</span>
          <br> <span style="font-size:10pt">Email: <span style="color:blue; font-style: italic;"> smkbaabulkamil_jatinangor@yahoo.com </span></span>
          | <span style="font-size:10pt">Website : <span style="color:blue;font-style: italic;">www.smkbaabulkamil.sch.id</span></span>
          </p>
        </div>
        <div class="garis_dua"></div>
      </div>
    </header>
        <center><h3>@yield('title')</h3></center>
        @yield('content')
  </body>
</html>