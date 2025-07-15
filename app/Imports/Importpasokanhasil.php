<?php

namespace App\Imports;

use App\Models\Pasokan_hasil_olah_bbm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importpasokanhasil implements ToModel, WithStartRow, WithMultipleSheets
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
        return new Pasokan_hasil_olah_bbm([
            'npwp' => Auth::user()->npwp,
            'bulan' => $this->bulan,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'nama_pemasok' => $row[0],
            'kategori_pemasok' => $row[1],
            'volume' => $row[2],
            'satuan' => $row[3],
        ]);
    }
}
