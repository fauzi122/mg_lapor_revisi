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
    protected $id_permohonan;
    protected $id_sub_page;

    public function __construct($bulan, $id_permohonan, $id_sub_page)
    {
        // $this->requestData = $requestData;
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
        // dd($this->id_permohonan);
        $tanggalExcel = $row[16];
        $tanggal = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($tanggalExcel - 2);
        $jenis_komoditas = explode(', ', $row[3]);
        return new Penyminyakbumi([
            'npwp' => Auth::user()->npwp,
            'id_permohonan' => $this->id_permohonan,
            'id_sub_page' => $this->id_sub_page,
            'bulan' => $this->bulan,
            'jenis_fasilitas' => $row[0],
            'no_tangki' => $row[1],
            'kapasitas_tangki' => $row[2],
            'jenis_komoditas' => $jenis_komoditas,
            'produk' => $row[4],
            'provinsi' => $row[5],
            'kab_kota' => $row[6],
            'kategori_supplai' => $row[7],
            'volume_stok_awal' => $row[8],
            'volume_supply' => $row[9],
            'volume_output' => $row[10],
            'volume_stok_akhir' => $row[11],
            'satuan' => $row[12],
            'kapasitas_penyewaan' => $row[13],
            'utilisasi_tangki' => $row[14],
            'pengguna' => $row[15],
            'jangka_waktu_penggunaan' => substr($tanggal, 0, 10),
            'tarif_penyimpanan' => $row[17],
            'satuan_tarif' => $row[18],
            'keterangan' => $row[19],
            'commingle' => $row[20],
            'jumlah_bu' => $row[21],
            'nama_penyewa' => $row[22],
        ]);
    }
}
