<?php

namespace App\Imports;

use App\Models\PenjualanGBP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class Importgbppenjualan implements ToModel, WithStartRow, WithMultipleSheets
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
        return new PenjualanGBP([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan' => $this->requestData,
            'provinsi' => $row[0],
            'kabupaten_kota' => $row[1],
            'sektor' => $row[2],
            'konsumen' => $row[3],
            'jumlah_hari_penyaluran' => $row[4],
            'ghv' => $row[5],
            'volume_mmbtu' => $row[6],
            'volume_mscf' => $row[7],
            'volume_m3' => $row[8],
            'harga' => $row[9],
            'keterangan' => $row[10],
        ]);
    }
}
