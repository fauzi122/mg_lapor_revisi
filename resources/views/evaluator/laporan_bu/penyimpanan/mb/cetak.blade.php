<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename={$title}.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>

		<!DOCTYPE html>
<html>

<head>
	<title>EVALUATOR | {{$title}} </title>
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
		<strong >{{$title}}</strong>
	</h5>
</div>
<table class="table table-light" style="font-size: 12px; border-collapse: collapse; border: 1px solid black;">
	<thead style="background-color: #f2f2f2;">
	<tr>
		<th style="border: 1px solid black;">NO</th>
		<th style="border: 1px solid black;">NAMA PERUSAHAAN</th>
		<th style="border: 1px solid black;">BULAN</th>
		<th style="border: 1px solid black;">JENIS FASILITAS</th>
		<th style="border: 1px solid black;">NO TANGKI</th>
		<th style="border: 1px solid black;">JENIS KOMODITAS</th>
		<th style="border: 1px solid black;">PRODUK</th>
		<th style="border: 1px solid black;">PROVINSI</th>
		<th style="border: 1px solid black;">KABUPATEN/KOTA</th>
		<th style="border: 1px solid black;">KATEGORI SUPPLAI</th>
		<th style="border: 1px solid black;">VOLUME STOK AWAL</th>
		<th style="border: 1px solid black;">VOLUME SUPPLY</th>
		<th style="border: 1px solid black;">VOLUME OUTPUT</th>
		<th style="border: 1px solid black;">VOLUME STOK AKHIR</th>
		<th style="border: 1px solid black;">SATUAN</th>
		<th style="border: 1px solid black;">UTILASI TANGKI</th>
		<th style="border: 1px solid black;">PENGGUNA</th>
		<th style="border: 1px solid black;">JANGKA WAKTU PENGGUNAAN</th>
		<th style="border: 1px solid black;">TARIF PENYIMPANAN</th>
		<th style="border: 1px solid black;">SATUAN TARIF</th>
		<th style="border: 1px solid black;">KETERANGAN</th>
		<th style="border: 1px solid black;">STATUS</th>
		<th style="border: 1px solid black;">CATATAN</th>
	</tr>
	</thead>
	<tbody>
	@foreach($result as $pgb)
		<tr>
			<td style="border: 1px solid black;">{{ $loop->iteration }}</td>
			<td style="border: 1px solid black;">{{ $pgb->NAMA_PERUSAHAAN }}</td>
			<td style="border: 1px solid black;">{{ dateIndonesia($pgb->bulan) }}</td>
			<td style="border: 1px solid black;">{{ $pgb->jenis_fasilitas }}</td>
			<td style="border: 1px solid black;">{{ $pgb->no_tangki }}</td>
			<td style="border: 1px solid black;">{{ $pgb->jenis_komoditas }}</td>
			<td style="border: 1px solid black;">{{ $pgb->produk }}</td>
			<td style="border: 1px solid black;">{{ $pgb->provinsi }}</td>
			<td style="border: 1px solid black;">{{ $pgb->kab_kota }}</td>
			<td style="border: 1px solid black;">{{ $pgb->kategori_supplai }}</td>
			<td style="border: 1px solid black;">{{ $pgb->volume_stok_awal }}</td>
			<td style="border: 1px solid black;">{{ $pgb->volume_supply }}</td>
			<td style="border: 1px solid black;">{{ $pgb->volume_output }}</td>
			<td style="border: 1px solid black;">{{ $pgb->volume_stok_akhir }}</td>
			<td style="border: 1px solid black;">{{ $pgb->satuan }}</td>
			<td style="border: 1px solid black;">{{ $pgb->utilasi_tangki }}</td>
			<td style="border: 1px solid black;">{{ $pgb->pengguna }}</td>
			<td style="border: 1px solid black;">{{ $pgb->jangka_waktu_penggunaan }}</td>
			<td style="border: 1px solid black;">{{ $pgb->tarif_penyimpanan }}</td>
			<td style="border: 1px solid black;">{{ $pgb->satuan_tarif }}</td>
			<td style="border: 1px solid black;">{{ $pgb->keterangan }}</td>



			<td  style="border: 1px solid black;">
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