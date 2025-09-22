<?php

namespace App\Exports;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;


class PenjualanBphPasokanGasBumiExport
{
    protected $query;
    protected $format;

    public function __construct($query, $format = 'xlsx')
    {
        $this->query = $query;

        // Mapping 'excel' menjadi 'xlsx'
        $format = strtolower($format);
        if ($format === 'excel') $format = 'xlsx';

        $this->format = $format;
    }

    public function export()
    {
        $filename = 'pasokan_Gas_Bumi.' . $this->format;

        // Pilih writer sesuai format
        if ($this->format === 'csv') {
            $writer = WriterEntityFactory::createCSVWriter();
            header('Content-Type: text/csv; charset=utf-8');
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }

        header("Content-Disposition: attachment; filename=\"{$filename}\"");

        // Open writer ke browser (argumen wajib)
        $writer->openToBrowser($filename);

        // Header kolom
        $header = WriterEntityFactory::createRowFromArray([
            'No',
            'Nama Badan Usaha',
            'NPWP',
            'Izin Usaha',
            'Bulan',
            'Tahun',
            'Nama Pemasok',
            'Harga Pasok',
            'Volume MMBTU',
        ]);
        $writer->addRow($header);

        // Nomor urut mulai dari 1
        $no = 1;

        // Data (jika query kosong, hanya header)
        foreach ($this->query->cursor() as $row) {
            $izinText = '';
            $izin = json_decode($row->izin_usaha);
            if (!empty($izin)) {
                foreach ($izin as $item) {
                    $izinText .= "ID: {$item->id_izin_usaha} - NOMOR: {$item->nomor_izin_usaha} | ";
                }
                $izinText = rtrim($izinText, " | ");
            }

            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $no,
                $row->nama_badan_usaha,
                $row->npwp_badan_usaha,
                $izinText,
                $row->bulan,
                $row->tahun,
                $row->nama_pemasok,
                $row->harga_pasok,
                $row->volume_mmbtu,
            ]));

            $no++;
        }

        $writer->close();
        exit; // hentikan eksekusi Laravel setelah export
    }


    public function exportMini()
    {
        $filename = 'pasokan_Gas_Bumi.' . $this->format;

        // Pilih writer sesuai format
        if ($this->format === 'csv') {
            $writer = WriterEntityFactory::createCSVWriter();
            header('Content-Type: text/csv; charset=utf-8');
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }

        header("Content-Disposition: attachment; filename=\"{$filename}\"");

        // Open writer ke browser (argumen wajib)
        $writer->openToBrowser($filename);

        // Header kolom
        $header = WriterEntityFactory::createRowFromArray([
            'No',
            'Bulan',
            'Tahun',
            'Nama Pemasok',
            'Harga Pemasok',
            'Volume MMBTU'
        ]);
        $writer->addRow($header);

        // Nomor urut mulai dari 1
        $no = 1;

        // Data (jika query kosong, hanya header)
        foreach ($this->query->cursor() as $row) {

            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $no,
                $row->bulan,
                $row->tahun,
                $row->nama_pemasok,
                $row->harga_pasok,
                $row->volume_mmbtu,
            ]));

            $no++;
        }

        $writer->close();
        exit; // hentikan eksekusi Laravel setelah export
    }
}