<?php

namespace App\Imports;

use App\Models\Penyminyakbumi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Auth;

class Importpenyimpananmb implements ToModel, WithStartRow, WithMultipleSheets
{
    /**
     * @return int
     */

    // protected $requestData;
    protected $bulan; 
    protected $izin_id;

    public function __construct($bulan,$izin_id)
    {
        // $this->requestData = $requestData;
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
        // dd($this->izin_id);
        $tanggalExcel = $row[14];
        $tanggal = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalExcel - 2);
        $jenis_komoditas = explode(', ', $row[2]);
        return new Penyminyakbumi([
            'badan_usaha_id' => Auth::user()->badan_usaha_id,
            'izin_id' => $this->izin_id,
            'bulan' => $this->bulan,
            'jenis_fasilitas' => $row[0],
            'no_tangki' => $row[1],
            'jenis_komoditas' => $jenis_komoditas,
            'produk' => $row[3],
            'provinsi' => $row[4],
            'kab_kota' => $row[5],
            'kategori_supplai' => $row[6],
            'volume_stok_awal' => $row[7],
            'volume_supply' => $row[8],
            'volume_output' => $row[9],
            'volume_stok_akhir' => $row[10],
            'satuan' => $row[11],
            'utilisasi_tangki' => $row[12],
            'pengguna' => $row[13],
            'jangka_waktu_penggunaan' => substr($tanggal, 0, 10),
            'tarif_penyimpanan' => $row[15],
            'satuan_tarif' => $row[16],
            'keterangan' => $row[17],
        ]);
    }
}
