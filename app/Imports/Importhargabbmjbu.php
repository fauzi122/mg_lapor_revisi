<?php

namespace App\Imports;

use App\Models\Harga_bbm_jbu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Importhargabbmjbu implements ToModel, WithStartRow, WithMultipleSheets
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
        return new Harga_bbm_jbu([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan' => $this->bulan,
            'produk' => $row[0],
            'sektor' => $row[1],
            'provinsi' => $row[2],
            'volume' => $row[3],
            'biaya_perolehan' => $row[4],
            'biaya_distribusi' => $row[5],
            'biaya_penyimpanan' => $row[6],
            'margin' => $row[7],
            'ppn' => $row[8],
            'pbbkp' => $row[9],
            'harga_jual' => $row[10],
            'formula_harga' => $row[11],
            'keterangan' => $row[12],
            'id_sub_page' => $this->id_sub_page,
]);
    }
}
