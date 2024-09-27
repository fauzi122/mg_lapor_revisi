<?php

namespace App\Imports;

use App\Models\Impor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Importimport implements ToModel, WithStartRow, WithMultipleSheets
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
        return new Impor([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'bulan_pib' => $this->requestData,
            'produk' => $row[0],
            'hs_code' => $row[1],
            'volume_pib' => $row[2],
            'satuan' => $row[3],
            'invoice_amount_nilai_pabean' => $row[4],
            'invoice_amount_final' => $row[5],
            'nama_supplier' => $row[6],
            'negara_asal' => $row[7],
            'pelabuhan_muat' => $row[8],
            'pelabuhan_bongkar' => $row[9],
            'vessel_name' => $row[10],
            'tanggal_bl' => $row[11],
            'bl_no' => $row[12],
            'no_pendaf_pib' => $row[13],
            'tanggal_pendaf_pib' => $row[14],
            'incoterms' => $row[15],
        ]);
    }
}
