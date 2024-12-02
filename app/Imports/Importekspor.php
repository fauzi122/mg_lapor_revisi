<?php

namespace App\Imports;

use App\Models\Ekspor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Importekspor implements ToModel, WithStartRow, WithMultipleSheets
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
        $tanggalBL = $row[10];
        $tanggalPendaftaran = $row[13];
        $tanggal1 = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalBL - 2);
        $tanggal2 = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalPendaftaran - 2);
        return new Ekspor([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => $this->izin_id,
            'bulan_peb' => $this->bulan,
            'produk' => $row[0],
            'hs_code' => $row[1],
            'volume_peb' => $row[2],
            'satuan' => $row[3],
            'invoice_amount_nilai_pabean' => $row[4],
            'invoice_amount_final' => $row[5],
            'nama_konsumen' => $row[6],
            'pelabuhan_muat' => $row[7],
            'negara_tujuan' => $row[8],
            'vessel_name' => $row[9],
            'tanggal_bl' => substr($tanggal1, 0, 10),
            'bl_no' => $row[11],
            'no_pendaf_peb' => $row[12],
            'tanggal_pendaf_peb' => substr($tanggal2, 0, 10),
            'incoterms' => $row[14],
        ]);
    }
}
