<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename={$title}.xls");
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
?>

<!DOCTYPE html>
<html>

<head>
    <title>EVALUATOR | {{ $title }} </title>
    <style>
        /* Gaya CSS untuk kop surat */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .kop-surat h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .kop-surat p {
            font-size: 12px;
            margin: 5px 0;
        }

        .kop-surat .alamat {
            font-style: italic;
        }

        .tanda-tangan {
            width: 100%;
        }

        .tanda-tangan-kanan {
            text-align: right;
        }

        .tanda-tangan-kiri {
            text-align: left;
            margin-top: 20px;
            /* Ubah nilai sesuai kebutuhan */

        }
    </style>
</head>

<body style="font-family: 'Times New Roman', Times, serif;">
    <div class="kop-surat">
        <h5 class="card-title" style="font-size: 14px;">
            <strong>{{ $title }}</strong>
        </h5>
    </div>
    <table class="table table-light" style="font-size: 12px; border-collapse: collapse; border: 1px solid black;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="border: 1px solid black;">NO</th>
                <th style="border: 1px solid black;">NAMA PERUSAHAAN</th>
                <th style="border: 1px solid black;">NPWP PERUSAHAAN</th>
                <th style="border: 1px solid black;">IZIN USAHA</th>
                <th style="border: 1px solid black;">BULAN</th>
                <th style="border: 1px solid black;">TAHUN</th>
                <th style="border: 1px solid black;">RUAS ANGKUT</th>
                <th style="border: 1px solid black;">DIAMETER</th>
                <th style="border: 1px solid black;">SHIPPER</th>
                <th style="border: 1px solid black;">TARIF MSCF</th>
                <th style="border: 1px solid black;">VOLUME MSCF</th>
                <th style="border: 1px solid black;">SATUAN MSCF</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result as $laporan)
                <tr>
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->nama_badan_usaha }}</td>
                    <td style="border: 1px solid black;">'{{ $laporan->npwp_badan_usaha }}</td>
                    <td style="border: 1px solid black;">
                        @php
                            $izin = json_decode($laporan->izin_usaha);
                        @endphp
                        <ul>
                            @foreach ($izin as $item)
                                <li>ID: {{ $item->id_izin_usaha }} - NOMOR: {{ $item->nomor_izin_usaha }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td style="border: 1px solid black;">{{ $laporan->bulan }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->tahun }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->ruas_angkut }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->diameter }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->shipper }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->tarif_mscf }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->volume_mscf }}</td>
                    <td style="border: 1px solid black;">{{ $laporan->satuan_mscf }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>


    <br>
    <table class="tanda-tangan" style=" font-size: 12px">
        <tr>


        </tr>
    </table>
    <br>
    <table class="tanda-tangan" style=" font-size: 12px">
        <tr>


        </tr>
    </table>





</body>


</html>
