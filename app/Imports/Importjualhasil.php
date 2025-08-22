<?php

namespace App\Imports;

use App\Models\Jual_hasil_olah_bbm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importjualhasil implements ToModel, WithStartRow, WithMultipleSheets
{

    /**
     * @return int
     */
    protected 
        $bulan, 
        $id_permohonan, 
        $id_sub_page;

    public function __construct($bulan, $id_permohonan, $id_sub_page)
    {
        $this->id_permohonan = $id_permohonan;
        $this->id_sub_page = $id_sub_page;
        $this->bulan = $bulan;
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
        return new Jual_hasil_olah_bbm([
            'npwp' => Auth::user()->npwp,
            'bulan' => $this->bulan,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'produk' => $row[0],
            'satuan' => $row[1],
            'provinsi' => $row[2],
            'kabupaten_kota' => $row[3],
            'sektor' => $row[4],
            'volume' => $row[5],

        ]);
    }
}
