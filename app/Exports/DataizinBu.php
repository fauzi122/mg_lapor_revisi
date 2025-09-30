<?php

namespace App\Exports;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;


class DataizinBu
{
    protected $result;
    protected $format;

    public function __construct($result, $format = 'xlsx')
    {
        $this->result = $result;

        // Mapping 'excel' menjadi 'xlsx'
        $format = strtolower($format);
        if ($format === 'excel') $format = 'xlsx';

        $this->format = $format;
    }

    public function exportMinyakBumi()
    {
        $filename = 'Minyak_Bumi_Badan_Usaha.' . $this->format;

        // Pilih writer sesuai format
        if ($this->format === 'csv') {
            $writer = WriterEntityFactory::createCSVWriter();
            header('Content-Type: text/csv; charset=utf-8');
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }

        header("Content-Disposition: attachment; filename=\"{$filename}\"");

        // Open writer ke browser
        $writer->openToBrowser($filename);

        // Header kolom
        $header = WriterEntityFactory::createRowFromArray([
            'No',
            'Nama Perusahaan',
            'Nama Provinsi',
            'Nama Kota',
            'Email Perusahaan',
            'Telepon',
            'Izin',   // ✅ sudah disesuaikan
            'Alamat',
            'Jenis Izin',
            'Nama Opsi',
            'Tanggal Disetujui',
            'Nomor Izin',
            'File Izin'
        ]);
        $writer->addRow($header);

        // Nomor urut mulai dari 1
        $no = 1;

        // Data
        foreach ($this->result->cursor() as $row) {
            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $no,
                $row->NAMA_PERUSAHAAN ?? '',
                $row->nama_provinsi ?? '',
                $row->nama_kota ?? '',
                $row->EMAIL_PERUSAHAAN ?? '',
                $row->TELEPON ?? '',
                $row->NAMA_TEMPLATE ?? '',   // ✅ ganti dari $izinText ke field query
                $row->ALAMAT ?? '',
                $row->SUB_PAGE ?? '',
                $row->nama_opsi ?? '',
                $row->TGL_DISETUJUI ?? '',
                $row->NOMOR_IZIN ?? '',
                $row->FILE_IZIN ?? '',
            ]));

            $no++;
        }

        $writer->close();
        exit; // hentikan eksekusi Laravel setelah export
    }

    public function exportGasBumi()
    {
        $filename = 'Gas_Bumi_Badan_Usaha.' . $this->format;

        // Pilih writer sesuai format
        if ($this->format === 'csv') {
            $writer = WriterEntityFactory::createCSVWriter();
            header('Content-Type: text/csv; charset=utf-8');
        } else {
            $writer = WriterEntityFactory::createXLSXWriter();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }

        header("Content-Disposition: attachment; filename=\"{$filename}\"");

        // Open writer ke browser
        $writer->openToBrowser($filename);

        // Header kolom
        $header = WriterEntityFactory::createRowFromArray([
            'No',
            'Nama Perusahaan',
            'Nama Provinsi',
            'Nama Kota',
            'Email Perusahaan',
            'Telepon',
            'Izin',   // ✅ sudah disesuaikan
            'Alamat',
            'Jenis Izin',
            'Nama Opsi',
            'Tanggal Disetujui',
            'Nomor Izin',
            'File Izin'
        ]);
        $writer->addRow($header);

        // Nomor urut mulai dari 1
        $no = 1;

        // Data
        foreach ($this->result->cursor() as $row) {
            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $no,
                $row->NAMA_PERUSAHAAN ?? '',
                $row->nama_provinsi ?? '',
                $row->nama_kota ?? '',
                $row->EMAIL_PERUSAHAAN ?? '',
                $row->TELEPON ?? '',
                $row->NAMA_TEMPLATE ?? '',   // ✅ ganti dari $izinText ke field query
                $row->ALAMAT ?? '',
                $row->SUB_PAGE ?? '',
                $row->nama_opsi ?? '',
                $row->TGL_DISETUJUI ?? '',
                $row->NOMOR_IZIN ?? '',
                $row->FILE_IZIN ?? '',
            ]));

            $no++;
        }

        $writer->close();
        exit; // hentikan eksekusi Laravel setelah export
    }
}