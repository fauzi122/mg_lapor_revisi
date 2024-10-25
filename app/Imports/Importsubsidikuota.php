<?php

namespace App\Imports;

use App\Models\kuota_lpg_subsidi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class Importsubsidikuota implements ToModel, WithStartRow, SkipsOnError, WithHeadingRow, WithMultipleSheets // Added WithHeadingRow if headers are used
{
    use Importable;

    private $tahun;
    private $petugas;

    public function __construct($tes)
    {
        $this->tahun   = $tes['tahun'];
        $this->petugas = $tes['petugas'];
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
        return 2; // Assuming the first row is the header row, though WithHeadingRow makes this redundant
    }

    public function model(array $row)
    {
        
        $defaultTanggal = $this->tahun . '-01';
        return kuota_lpg_subsidi::create([
            'tahun'    => $defaultTanggal,
            'provinsi'       => $row['provinsi'],
            'kabupaten_kota' => ucwords(strtolower($row['kabupatenkota'])),
            'volume'         => $row['volume'],
            'petugas'        => $this->petugas,
        ]);
    }

    public function onError(Throwable $error)
    {
        // Optionally log the error or handle it as per your requirements
    }

    // Metode getter untuk counter pembaruan
    public function getUpdatesCount()
    {
        // Need to define or track updatesCount if used
    }
}