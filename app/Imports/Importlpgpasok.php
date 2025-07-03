<?php

namespace App\Imports;

use App\Models\PasokanLPG;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importlpgpasok implements ToModel, WithStartRow, WithMultipleSheets
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
        return new PasokanLPG([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan' => $this->bulan,
            'nama_pemasok' => $row[0],
            'kategori_pemasok' => $row[1],
            'volume' => $row[2],
            'satuan' => $row[3],
        ]);
    }
}
