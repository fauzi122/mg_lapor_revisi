<?php

namespace App\Imports;

use App\Models\Penjualan_lpg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importlpgpenjualan implements ToModel, WithStartRow, WithMultipleSheets
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
        return new Penjualan_lpg([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => $this->izin_id,
            'bulan' => $this->bulan,
            'provinsi' => $row[0],
            'kabupaten_kota' => $row[1],
            'produk' => $row[2],
            'sektor' => $row[3],
            'kemasan' => $row[4],
            'volume' => $row[5],
            'satuan' => $row[6],
        ]);
    }
}
