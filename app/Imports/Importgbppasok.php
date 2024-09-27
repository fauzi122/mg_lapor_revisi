<?php

namespace App\Imports;

use App\Models\pasokanGBP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Importgbppasok implements ToModel, WithStartRow, WithMultipleSheets
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
        return new pasokanGBP([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan' => $this->requestData,
            'nama_pemasok' => $row[0],
            'volume_mmbtu' => $row[1],
            'volume_mscf' => $row[2],
            'volume_m3' => $row[3],
            'harga' => $row[4],
        ]);
    }
}
