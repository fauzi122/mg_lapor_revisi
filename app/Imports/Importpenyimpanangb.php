<?php

namespace App\Imports;

use App\Models\Penygasbumi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importpenyimpanangb implements ToModel, WithStartRow, WithMultipleSheets
{
    /**
     * @return int
     */
    protected $bulan; 
    protected $id_permohonan;
    protected $id_sub_page;

    public function __construct($bulan, $id_permohonan, $id_sub_page)
    {
        $this->bulan = $bulan; 
        $this->id_permohonan = $id_permohonan;
        $this->id_sub_page = $id_sub_page;
    }

    public function sheets(): array
    {
        return [
            0 => $this, // 0 adalah indeks sheet pertama
            // Tambahkan sheet lain jika diperlukan
        ];
    }

    public function startRow(): int
    {
        return 2; // Mulai membaca data dari baris kedua (baris pertama dilewati sebagai header)
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Ubah nilai numerik Excel ke format tanggal
        $tglAwal = $row[10];
        $tanggalAwal = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tglAwal - 2);
        $tglAkhir = $row[11];
        $tanggalAkhir = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tglAkhir - 2);
        // echo json_encode(substr($tanggal, 0, 10));
        // exit;
        return new Penygasbumi([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan' => $this->bulan,
            'no_tangki' => $row[0],
            'produk' => $row[1],
            'satuan' => $row[2],
            'kab_kota' => $row[3],
            'volume_stok_awal' => $row[4],
            'volume_supply' => $row[5],
            'volume_output' => $row[6],
            'volume_stok_akhir' => $row[7],
            'utilisasi_tangki' => $row[8],
            'pengguna' => $row[9],
            // 'jangka_waktu_penggunaan' => substr($tanggalAwal, 0, 10),
            'tanggal_awal' => substr($tanggalAwal, 0, 10),
            'tanggal_berakhir' => substr($tanggalAkhir, 0, 10),
            'tarif_penyimpanan' => $row[12],
            'satuan_tarif' => $row[13],
        ]);
    }
}
