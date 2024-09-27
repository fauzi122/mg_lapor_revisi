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
        return new Jual_hasil_olah_bbm([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan' => $this->requestData,
            'produk' => $row[0],
            'provinsi' => $row[1],
            'kabupaten_kota' => $row[2],
            'sektor' => $row[3],
            'volume' => $row[4],
            'satuan' => $row[5],

        ]);
    }
}
