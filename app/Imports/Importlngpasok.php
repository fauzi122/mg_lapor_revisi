<?php

namespace App\Imports;

use App\Models\Pasokanlng;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importlngpasok implements ToModel, WithStartRow, WithMultipleSheets
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
        // echo json_encode($row);exit;
        return new Pasokanlng([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => $this->izin_id,
            'bulan' => $this->bulan,
            'produk' => $row[0],
            'nama_pemasok' => $row[1],
            'kategori_pemasok' => $row[2],
            'volume' => $row[3],
            'satuan' => $row[4],
            'harga_gas' => $row[5],
            'satuan_harga_gas' => $row[6],
        ]);
    }
}
