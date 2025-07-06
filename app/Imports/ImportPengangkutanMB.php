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
    protected $bulan; 
    protected $id_permohonan;
    protected $id_sub_page;

    public function __construct($bulan,$id_permohonan, $id_sub_page)
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
        $jenis_moda = explode(', ', $row[1]);
        return new pengangkutan_minyakbumi([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan' => $this->bulan,
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
