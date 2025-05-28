@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0"
                                    role="alert">
                                    <i class="mdi mdi-alert-circle-outline label-icon"></i>
                                    <strong>Informasi:</strong> Data yang ditampilkan di halaman ini adalah data untuk bulan
                                    berjalan.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode {{ $periode }}</h4>
                                    <div>
                                        <a href="{{ url('/laporan/penjualan-jbt') }}"
                                            class="btn btn-danger waves-effect waves-light">
                                            <i class='bx bx-arrow-back'></i> Kembali
                                        </a>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                            <i class='bx bx-filter-alt'></i> Filter
                                        </button>


                                        {{-- Modal cetak --}}
                                        <div class="modal fade modal-select bs-example-modal-center" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Filter</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('laporan/penjualan-jbt-lihat-semua-data') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Nama
                                                                    Perusahaan</label>
                                                                <select
                                                                    class="form-control select20 select2-hidden-accessible mb-2"
                                                                    style="width: 100%;" name="perusahaan" required>
                                                                    <option value="all" selected>--Pilih Perusahaan--
                                                                    </option>
                                                                    <option value="all">Semua Perusahaan</option>
                                                                    @foreach ($perusahaan as $p)
                                                                        <option value="{{ $p->id_badan_usaha }}">
                                                                            {{ $p->nama_badan_usaha }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Awal</label>
                                                                <input class="form-control" name="t_awal" type="month"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Akhir</label>
                                                                <input class="form-control" name="t_akhir" type="month"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="submit" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Proses</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons"
                                        class="table table-bordered table-striped dt nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Badan Usaha</th>
                                                <th>NPWP Badan Usaha</th>
                                                <th>Izin Usaha</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $pgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pgb->nama_badan_usaha }}</td>
                                                    <td>{{ $pgb->npwp_badan_usaha }}</td>
                                                    <td>
                                                        @php
                                                            $izinList = json_decode($pgb->izin_usaha, true); // jika izin_usaha disimpan dalam bentuk JSON string
                                                        @endphp

                                                        @if (is_array($izinList))
                                                            <ul style="margin: 0; padding-left: 15px;">
                                                                @foreach ($izinList as $izin)
                                                                    <li>ID: {{ $izin['id_izin_usaha'] ?? '-' }} - Nomor:
                                                                        {{ $izin['nomor_izin_usaha'] ?? '-' }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <span class="text-muted">Tidak ada data</span>
                                                        @endif
                                                    </td>

                                                    <td>{{ bulan($pgb->bulan) }}</td>
                                                    <td>{{ $pgb->tahun }}</td>
                                                    <td>{{ $pgb->produk }}</td>
                                                    <td>{{ $pgb->provinsi }}</td>
                                                    <td>{{ $pgb->kabupaten_kota }}</td>
                                                    <td>{{ $pgb->sektor }}</td>
                                                    <td>{{ $pgb->volume }}</td>
                                                    <td>{{ $pgb->satuan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
