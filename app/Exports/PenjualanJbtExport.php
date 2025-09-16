<?php

namespace App\Exports;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Illuminate\Support\Facades\DB;

class PenjualanJbtExport
{
    protected $t_awal;
    protected $t_akhir;
    protected $perusahaan;

    public function __construct($t_awal, $t_akhir, $perusahaan)
    {
        $this->t_awal = $t_awal;
        $this->t_akhir = $t_akhir;
        $this->perusahaan = $perusahaan;
    }

    public function export()
    {
        // Buat writer untuk XLSX
        $writer = WriterEntityFactory::createXLSXWriter();

        // Kirim output langsung ke browser (download otomatis)
        $writer->openToBrowser('penjualan_jbt.xlsx');

        // Header (Judul Kolom Excel)
        $header = WriterEntityFactory::createRowFromArray([
            'Nama Badan Usaha',
            'NPWP Badan Usaha',
            'Izin Usaha',
            'Bulan',
            'Tahun',
            'Produk',
            'Provinsi',
            'Kabupaten/Kota',
            'Sektor',
            'Volume',
            'Satuan',
        ]);
        $writer->addRow($header);

        // Ambil data dari tabel bph_penjualan_jbt
        $query = DB::table('bph_penjualan_jbt')
            ->whereRaw('((tahun::int * 100) + bulan::int) BETWEEN ? AND ?', [$this->t_awal, $this->t_akhir])
            ->orderByRaw('tahun::int')
            ->orderByRaw('bulan::int');


        // Jika ada filter perusahaan selain 'all'
        if ($this->perusahaan && $this->perusahaan !== 'all') {
            $query->where('id_badan_usaha', (int)$this->perusahaan);
        }

        // Gunakan cursor() supaya hemat memory
        foreach ($query->cursor() as $row) {
            $izin = json_decode($row->izin_usaha);
            $izinText = '';
            if (!empty($izin)) {
                foreach ($izin as $item) {
                    $izinText .= "ID: {$item->id_izin_usaha} - NOMOR: {$item->nomor_izin_usaha} | ";
                }
                $izinText = rtrim($izinText, " | ");
            }

            // Tambahkan baris data ke Excel
            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $row->nama_badan_usaha,
                $row->npwp_badan_usaha,
                $izinText,
                $row->bulan,
                $row->tahun,
                $row->produk,
                $row->provinsi,
                $row->kabupaten_kota,
                $row->sektor,
                $row->volume,
                $row->satuan,
            ]));
        }

        // Tutup writer (selesai menulis)
        $writer->close();
    }
}
