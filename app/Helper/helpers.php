<?php

use Mews\Purifier\Facades\Purifier;

function hari_ini() {
    $hari = date("D");
    switch($hari) {
        case 'Sun':
            return "Minggu";
        case 'Mon':
            return "Senin";
        case 'Tue':
            return "Selasa";
        case 'Wed':
            return "Rabu";
        case 'Thu':
            return "Kamis";
        case 'Fri':
            return "Jumat";
        case 'Sat':
            return "Sabtu";
        default:
            return "Tidak diketahui";
    }
}

function bulan($bulan) {
    $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT); // Ubah jadi 2 digit
    
    $arrayBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    return $arrayBulan[$bulan] ?? 'Bulan tidak ditemukan';
}

function dateIndonesia($date) {
    if($date != '0000-00-00') {
        $date = explode('-', $date);
        return bulan($date[1]) . ' '. $date[0];
    } else {
        return 'Format tanggal salah';
    }
}

function rupiah($angka) {
    return "Rp " . number_format($angka, 2, ',', '.');
}

function getBulan($date) {
    $bulan = date('m', strtotime($date));
    return bulan($bulan);
}

function getTahun($date) {
    $tahun = date('Y', strtotime($date));
    return $tahun;
}

function fullySanitizeInput(array $input): array
{
    $sanitized = [];

    foreach ($input as $key => $value) {
        // Cek apakah numeric (angka) → konversi
        if (is_numeric($value)) {
            // Jika ada titik desimal, float
            $sanitized[$key] = strpos($value, '.') !== false
                ? floatval($value)
                : intval($value);
        } elseif (is_string($value)) {
            // Kalau string → bersihkan pakai Purifier
            $cleanText = Purifier::clean($value);
            $sanitized[$key] = strip_tags($cleanText);
        } else {
            // Biarkan tipe lain (array, file, dsb) tetap apa adanya
            $sanitized[$key] = $value;
        }
    }

    return $sanitized;
}




// Contoh penggunaan:
// echo "Hari ini adalah " . hari_ini();
// echo 'Hari ini : '.dateIndonesia(date('Y-m-d'));
// echo rupiah(1000000);
?>
