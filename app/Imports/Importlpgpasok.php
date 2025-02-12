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
     protected $izin_id;
 
     public function __construct($bulan,$izin_id)
     {
         $this->bulan = $bulan; 
         $this->izin_id = $izin_id;
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
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => $this->izin_id,
            'bulan' => $this->bulan,
            'nama_pemasok' => $row[0],
            'kategori_pemasok' => $row[1],
            'volume' => $row[2],
            'satuan' => $row[3],
        ]);
    }
}
