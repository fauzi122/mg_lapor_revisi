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
    protected $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
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
        $tanggalExcel = $row[10];
        $tanggal = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalExcel - 2);
        // echo json_encode(substr($tanggal, 0, 10));
        // exit;
        return new Penygasbumi([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan' => $this->requestData,
            'no_tangki' => $row[0],
            'produk' => $row[1],
            'kab_kota' => $row[2],
            'volume_stok_awal' => $row[3],
            'volume_supply' => $row[4],
            'volume_output' => $row[5],
            'volume_stok_akhir' => $row[6],
            'satuan' => $row[7],
            'utilasi_tangki' => $row[8],
            'pengguna' => $row[9],
            'jangka_waktu_penggunaan' => substr($tanggal, 0, 10),
            'tarif_penyimpanan' => $row[11],
            'satuan_tarif' => $row[12],
        ]);
    }
}
