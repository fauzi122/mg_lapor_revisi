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
                <th style="border: 1px solid black;">NAMA PERUSAHAAN </th>
                <th style="border: 1px solid black;">Nomor Izin </th>
                <th style="border: 1px solid black;">Tgl Pengajuan Izin</th>
                <th style="border: 1px solid black;">Tgl Disetujui Izin</th>
                <th style="border: 1px solid black;">BULAN</th>
                <th style="border: 1px solid black;">TAHUN</th>
                <th style="border: 1px solid black;">PRODUK</th>
                <th style="border: 1px solid black;">PROVINSI</th>
                <th style="border: 1px solid black;">KABUPATEN</th>
                <th style="border: 1px solid black;">SEKTOR</th>
                <th style="border: 1px solid black;">VOLUME</th>
                <th style="border: 1px solid black;">SATUAN</th>
                <th style="border: 1px solid black;">STATUS</th>
                <th style="border: 1px solid black;">CATATAN</th>
                <th style="border: 1px solid black;">Tgl Dibuat Laporan</th>
                <th style="border: 1px solid black;">Tgl Pengajuan Laporan</th>

            </tr>

        </thead>
        <tbody>
            @foreach ($result as $pgb)
                <tr>
                    <td style="border: 1px solid black;">{{ $loop->iteration }}</td>

                    <td style="border: 1px solid black;">{{ $pgb->NAMA_PERUSAHAAN }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->NOMOR_IZIN }}</td>
                    <td style="border: 1px solid black;">{{ \Carbon\Carbon::parse($pgb->TGL_PENGAJUAN)->format('Y-m-d') }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->TGL_DISETUJUI }}</td>
                    <td style="border: 1px solid black;">{{ getBulan($pgb->bulan) }}</td>
                    <td style="border: 1px solid black;">{{ getTahun($pgb->bulan) }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->produk }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->provinsi }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->kabupaten_kota }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->sektor }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->volume }}</td>
                    <td style="border: 1px solid black;">{{ $pgb->satuan }}</td>
                    <td style="border: 1px solid black;">
                        @if ($pgb->status == 1 && $pgb->catatan)
                            Sudah Diperbaiki
                        @elseif ($pgb->status == 1)
                            Kirim
                        @elseif ($pgb->status == 2)
                            Revisi
                        @elseif ($pgb->status == 3)
                            Selesa
                        @elseif ($pgb->status == 0)
                            draf
                        @endif


                    </td>
                    <td style="border: 1px solid black;">{{ $pgb->catatan }}</td>
                    <td style="border: 1px solid black;">{{ \Carbon\Carbon::parse($pgb->created_at)->format('Y-m-d') }}</td>
                    <td style="border: 1px solid black;">{{ \Carbon\Carbon::parse($pgb->tgl_kirim)->format('Y-m-d') }}</td>


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
