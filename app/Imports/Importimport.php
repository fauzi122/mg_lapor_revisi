<?php

namespace App\Imports;

use App\Models\Impor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Importimport implements ToModel, WithStartRow, WithMultipleSheets
{
    /**
     * @return int
     */
    protected $bulan; 
    protected $id_permohonan;
    protected $id_sub_page;

    public function __construct($bulan, $id_permohonan, $id_sub_page)
    {
        $this->bulan = $bulan; 
        $this->id_permohonan = $id_permohonan;
        $this->id_sub_page = $id_sub_page;
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
        $tanggalBL = $row[11];
        $tanggalPendaftaran = $row[14];
        $tanggal1 = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalBL - 2);
        $tanggal2 = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalPendaftaran - 2);
        
        return new Impor([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan_pib' => $this->bulan,
      
            'produk' => $row[0],
            'satuan' => $row[1],
            'hs_code' => $row[2],
            'volume_pib' => $row[3],
            'invoice_amount_nilai_pabean' => $row[4],
            'invoice_amount_final' => $row[5],
            'nama_supplier' => $row[6],
            'negara_asal' => $row[7],
            'pelabuhan_muat' => $row[8],
            'pelabuhan_bongkar' => $row[9],
            'vessel_name' => $row[10],
            'tanggal_bl' => substr($tanggal1, 0, 10),
            'bl_no' => $row[12],
            'no_pendaf_pib' => $row[13],
            'tanggal_pendaf_pib' => substr($tanggal2, 0, 10),
            'incoterms' => $row[15],
        ]);
    }
}
