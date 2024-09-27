<?php

namespace App\Imports;

use App\Models\Subsidilpg;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Importsubsidikuota implements ToModel, WithStartRow
{
    /**
     * @return int
     */
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
        return new Subsidilpg([
            'tahun' => $row[0],
            'provinsi' => $row[1],
            'kab_kota' => $row[2],
            'volume' => $row[3],
            'jenis' => $row[3],
        ]);
    }
}
