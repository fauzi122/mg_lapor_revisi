<?php

namespace App\Imports;

use App\Models\pengangkutan_minyakbumi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class ImportPengangkutanMB implements ToModel, WithStartRow, WithMultipleSheets
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
        $jenis_moda = explode(', ', $row[1]);
        return new pengangkutan_minyakbumi([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => '1',
            'bulan' => $this->requestData,
            'produk' => $row[0],
            'jenis_moda' => $jenis_moda,
            'node_asal' => $row[2],
            'provinsi_asal' => $row[3],
            'node_tujuan' => $row[4],
            'provinsi_tujuan' => $row[5],
            'volume_supply' => $row[6],
            'satuan_volume_supply' => $row[7],
            'volume_angkut' => $row[8],
            'satuan_volume_angkut' => $row[9],
        ]);
    }
}
