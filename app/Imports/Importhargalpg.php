<?php

namespace App\Imports;

use App\Models\HargaLPG;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importhargalpg implements ToModel, WithStartRow, WithMultipleSheets
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
        // echo json_encode($row);exit;
        return new HargaLPG([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'bulan' => $this->bulan,
            'sektor' => $row[0],
            'provinsi' => $row[1],
            'kabupaten_kota' => $row[2],
            'volume' => $row[3],
            'biaya_perolehan' => $row[4],
            'biaya_distribusi' => $row[5],
            'biaya_penyimpanan' => $row[6],
            'margin' => $row[7],
            'ppn' => $row[8],
            'harga_jual' => $row[9],
            'formula_harga' => $row[10],
            'keterangan' => $row[11],
            'id_sub_page' => $this->id_sub_page
        ]);
    }
}
