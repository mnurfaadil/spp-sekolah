<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin: 70px 50px;
        }

        header {
            position: fixed;
            top: -70px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 70px;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0px;
            right: 0px;
            background-color: lightblue;
            height: 70px;
        }

        table {
            border-collapse: collapse;
        }

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: never;
        }

        .box {
            height: 65mm;
            width: 85mm;
            background-color: pink;
            margin: auto;
        }

        .box-logo {
            height: 64px;
            width: 128px;
            background-color: pink;
            margin: auto;
        }

        .box-logo-left{
            height: 64px;
            width: 128px;
            background-color: pink;
        }

        .box-potrait{
            height: 170mm;
            width: 126mm;
            background-color: pink;
            margin: auto;
        }

        .box-landscape{
            height: 124mm;
            width: 166mm;
            background-color: pink;
            margin: auto;
        }

        .profil-foto {
            margin-top: 20px;
        }

        .profil-foto .title {
            margin-bottom: 20px;
            text-align: center;
        }

        .foto {
            padding-top: 5px;
            padding-bottom: 5px;
            background-color: cyan;
        }

        .description {
            text-align: center;
        }
    </style>
</head>

<body>
    <main>
        <div class="page">
            <div class="profil">
                <table border="1" width="100%">
                    <tr >
                        <th rowspan="3" width="50%">
                            <div class="box-logo">&nbsp;</div>
                        </th>
                        <th width="22%">SITE ID</th>
                        <td width="28%">_ID_SITUS_</td>
                    </tr>
                    <tr>
                        <th >SITE NAME</th>
                        <td >_nama_situs_</td>
                    </tr>
                    <tr>
                        <th >TOWER TYPE</th>
                        <td >_jenis_tower_</td>
                    </tr>
                    <tr>
                        <td>_judul_</td>
                        <th>DATA ISSUED</th>
                        <td>_tanggal_dibuat_</td>
                    </tr>
                    <tr>
                        <td><b>Addres : </b>_alamat_</td>
                        <th>DATA REVISION</th>
                        <td>_tanggal_direvisi_optional_</td>
                    </tr>
                </table>
            </div>
            <div class="profil-foto">
                <div class="title">_title_</div>
                <div class="box-potrait"></div>
            </div>
        </div>
        <div class="page">
            <div class="profil">
                <table border="1" width="100%">
                    <tr >
                        <th rowspan="3" width="50%">
                            <div class="box-logo">&nbsp;</div>
                        </th>
                        <th width="22%">SITE ID</th>
                        <td width="28%">_ID_SITUS_</td>
                    </tr>
                    <tr>
                        <th >SITE NAME</th>
                        <td >_nama_situs_</td>
                    </tr>
                    <tr>
                        <th >TOWER TYPE</th>
                        <td >_jenis_tower_</td>
                    </tr>
                    <tr>
                        <td>_judul_</td>
                        <th>DATA ISSUED</th>
                        <td>_tanggal_dibuat_</td>
                    </tr>
                    <tr>
                        <td><b>Addres : </b>_alamat_</td>
                        <th>DATA REVISION</th>
                        <td>_tanggal_direvisi_optional_</td>
                    </tr>
                </table>
            </div>
            <div class="profil-foto">
                <div class="title">_title_</div>
                <div class="box-landscape"></div>
            </div>
        </div>
        <div class="page">
            <div class="profil">
                <table border="1" width="100%">
                    <tr >
                        <th rowspan="3" width="50%">
                            <div class="box-logo">&nbsp;</div>
                        </th>
                        <th width="22%">SITE ID</th>
                        <td width="28%">_ID_SITUS_</td>
                    </tr>
                    <tr>
                        <th >SITE NAME</th>
                        <td >_nama_situs_</td>
                    </tr>
                    <tr>
                        <th >TOWER TYPE</th>
                        <td >_jenis_tower_</td>
                    </tr>
                    <tr>
                        <td>_judul_</td>
                        <th>DATA ISSUED</th>
                        <td>_tanggal_dibuat_</td>
                    </tr>
                    <tr>
                        <td><b>Addres : </b>_alamat_</td>
                        <th>DATA REVISION</th>
                        <td>_tanggal_direvisi_optional_</td>
                    </tr>
                </table>
            </div>
            <div class="profil-foto">
                <table border="1" width="100%">
                    <tr>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                    </tr>
                    <tr>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="page">
            <div class="profil">
                <table border="1" width="100%">
                    <tr >
                        <th rowspan="3" width="50%">
                            <div class="box-logo">&nbsp;</div>
                        </th>
                        <th width="22%">SITE ID</th>
                        <td width="28%">_ID_SITUS_</td>
                    </tr>
                    <tr>
                        <th >SITE NAME</th>
                        <td >_nama_situs_</td>
                    </tr>
                    <tr>
                        <th >TOWER TYPE</th>
                        <td >_jenis_tower_</td>
                    </tr>
                    <tr>
                        <td>_judul_</td>
                        <th>DATA ISSUED</th>
                        <td>_tanggal_dibuat_</td>
                    </tr>
                    <tr>
                        <td><b>Addres : </b>_alamat_</td>
                        <th>DATA REVISION</th>
                        <td>_tanggal_direvisi_optional_</td>
                    </tr>
                </table>
            </div>
            <div class="profil-foto">
                <table border="1" width="100%">
                    <tr>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                    </tr>
                    <tr>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                    </tr>
                    <tr>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                        <td width="50%">    
                            <div class="box"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                        <td>_PANORAMIK_VIEW_X_&deg;_</td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>
</html>