<?php

namespace App\Imports;

use App\Models\Penjualan_lng;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importlngpenjualan implements ToModel, WithStartRow, WithMultipleSheets
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
        return new Penjualan_lng([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan' => $this->requestData,
            'provinsi' => $row[0],
            'kabupaten_kota' => $row[1],
            'produk' => $row[2],
            'konsumen' => $row[3],
            'sektor' => $row[4],
            'volume' => $row[5],
            'satuan' => $row[6],
            'biaya_kompresi' => $row[7],
            'satuan_biaya_kompresi' => $row[8],
            'biaya_penyimpanan' => $row[9],
            'satuan_biaya_penyimpanan' => $row[10],
            'biaya_pengangkutan' => $row[11],
            'satuan_biaya_pengangkutan' => $row[12],
            'biaya_niaga' => $row[13],
            'satuan_biaya_niaga' => $row[14],
            'harga_bahan_baku' => $row[15],
            'satuan_harga_bahan_baku' => $row[16],
            'pajak' => $row[17],
            'satuan_pajak' => $row[18],
            'harga_jual' => $row[19],
            'satuan_harga_jual' => $row[20],
        ]);
    }
}
