@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan LNG/CNG/BBG </h4>
                    </div>
                </div>
            </div>

            {{-- Penjualan LNG/CNG --}}
            @if ($statuspenjualan_lngx != '' and $lngx == 'penjualan')
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Penjualan LNG/CNG/BBG </h5>
                                    @php
                                        $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                    @endphp
                                    <div>
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        @if ($statuspenjualan_lngx == 1)
                                            <form action="{{ url('/submit_bulan_lng') }}/{{ $id }}" method="post"
                                                class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))" disabled>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng" disabled>Import
                                                Excel</button>
                                        @elseif ($statuspenjualan_lngx == 2)
                                            <form action="{{ url('/submit_bulan_lng') }}/{{ $id }}" method="post"
                                                class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng" disabled>Import
                                                Excel</button>
                                        @else
                                            <form action="{{ url('/submit_bulan_lng') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#myModal">Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_penjualan_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_penjualan_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng">Import Excel</button>
                                        @endif
                                        @include('badan_usaha.niaga.lng.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Produk</th>
                                                <th>Aksi</th>
                                                <th>Konsumen</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan (MMBTU)</th>
                                                <th>Biaya Kompresi/Regasifikasi (USD/MMBTU)</th>
                                                <th>Biaya Penyimpanan (USD/MMBTU)</th>
                                                <th>Biaya Pengangkutan (USD/MMBTU)</th>
                                                <th>Biaya Niaga (USD/MMBTU)</th>
                                                <th>Harga Bahan Baku (USD/MMBTU)</th>
                                                <th>Pajak</th>
                                                <th>Harga Jual (USD/MMBTU)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lng as $lng)
                                                <tr>
                                                    <td>{{ getBulan($lng->bulan) }}</td>
                                                    <td>{{ getTahun($lng->bulan) }}</td>
                                                    <td>
                                                        @if ($lng->status == 1 && $lng->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($lng->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($lng->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($lng->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $lng->catatan }}</td>
                                                    <td>{{ $lng->provinsi }}</td>
                                                    <td>{{ $lng->kabupaten_kota }}</td>
                                                    <td>{{ $lng->produk }}</td>
                                                    <td>
                                                        <?php $status=$lng->status;
                                                        if ($status=="0") { ?>
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editPenjualan"
                                                                id="editCompany"
                                                                onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            <form action="{{ url('/hapus_lng') }}/{{ $lng->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng" data-id="{{ $lng->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } elseif ($status=="1") { ?>
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } elseif ($status=="2") { ?>
                                                        <center>
                                                            <button type="button"
                                                                class="btn btn-sm btn-info editPenjualan" id="editCompany"
                                                                onclick="edit_penjualan_lng('{{ $lng->id }}', '{{ $lng->produk }}' , '{{ $lng->kabupaten_kota }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $lng->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            {{-- <form action="/submit_lng/{{ $lng->id }}" method="post"
                                                                class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form> --}}
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lng('{{ $lng->id }}')"
                                                                data-bs-target="#lihat-lng"
                                                                data-id="{{ $lng->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                        <?php } ?>
                                                    </td>
                                                    <td>{{ $lng->konsumen }}</td>
                                                    <td>{{ $lng->sektor }}</td>
                                                    <td>{{ $lng->volume }}</td>
                                                    <td>{{ $lng->satuan }}</td>
                                                    <td>{{ $lng->satuan_biaya_kompresi }} {{ $lng->biaya_kompresi }}</td>
                                                    <td>{{ $lng->satuan_biaya_penyimpanan }} {{ $lng->biaya_penyimpanan }}
                                                    </td>
                                                    <td>{{ $lng->satuan_biaya_pengangkutan }}
                                                        {{ $lng->biaya_pengangkutan }}</td>
                                                    <td>{{ $lng->satuan_biaya_niaga }} {{ $lng->biaya_niaga }}</td>
                                                    <td>{{ $lng->satuan_harga_bahan_baku }} {{ $lng->harga_bahan_baku }}
                                                    </td>
                                                    <td>{{ $lng->satuan_pajak }} {{ $lng->pajak }}</td>
                                                    <td>{{ $lng->satuan_harga_jual }} {{ $lng->harga_jual }}</td>

                                                </tr>
                                            @endforeach
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row"></div>
            @endif
            {{-- Pasokan LNG/CNG --}}
            @if ($statuspasok_lngx != '' and $lngx == 'pasok')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Pasokan LNG/CNG/BBG</h5>
                                    <div>
                                        @php
                                            $id = Crypt::encryptString($pecah[0] . ',' . $pecah[1] . ',' . $pecah[2]);
                                        @endphp
                                        <a href="javascript:history.back()"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        @if ($statuspasok_lngx == 1)
                                            <form action="{{ url('/submit_bulan_pasok_lng') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))" disabled>
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok" disabled>Import
                                                Excel
                                            </button>
                                        @elseif ($statuspasok_lngx == 2)
                                            <form action="{{ url('/submit_bulan_pasok_lng') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng" disabled>Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok" disabled>Import
                                                Excel</button>
                                        @else
                                            <form action="{{ url('/submit_bulan_pasok_lng') }}/{{ $id }}"
                                                method="post" class="d-inline">
                                                @method('put')
                                                @csrf
                                                <button type="button" class="btn btn-info"
                                                    onclick="kirimData($(this).closest('form'))">
                                                    <span title="Kirim semua data">Kirim Semua</span>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                                onclick="produk(); provinsi(); tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#pasokan_lng">Buat Laporan
                                                {{ dateIndonesia($bulan_ambil_pasok_lngx) }}
                                            </button>
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                onclick="tambahPMB('{{ $bulan_ambil_pasok_lngx }}' )"
                                                data-bs-toggle="modal" data-bs-target="#excellng_pasok">Import
                                                Excel</button>
                                        @endif
                                        @include('badan_usaha.niaga.lng.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Produk</th>
                                                <th>Nama Pemasok</th>
                                                <th>Kategori Pemasok</th>
                                                <th>Aksi</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Harga Gas</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pasok_lng as $pasok)
                                                <tr>
                                                    <td>{{ getbulan($pasok->bulan) }}</td>
                                                    <td>{{ getTahun($pasok->bulan) }}</td>
                                                    <td>
                                                        @if ($pasok->status == 1 && $pasok->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pasok->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($pasok->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($pasok->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pasok->catatan }}</td>
                                                    <td>{{ $pasok->produk }}</td>
                                                    <td>{{ $pasok->nama_pemasok }}</td>
                                                    <td>{{ $pasok->kategori_pemasok }}</td>
                                                    <td>
                                                        <?php
                                            $status=$pasok->status;
                                            if ($status=="0"){ ?>
                                                        <center><button type="button"
                                                                class="btn btn-sm btn-info editPasok" id="editCompany"
                                                                onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit-pasok"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i></button>
                                                            <form
                                                                action="{{ url('/hapus_pasok_lng') }}/{{ $pasok->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button>
                                                        </center>

                                                        <?php 
                                            }elseif ($status=="1"){ ?>

                                                        <center><button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button></center>

                                                        <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button"
                                                                class="btn btn-sm btn-info editPasok" id="editCompany"
                                                                onclick="edit_pasokan_lng('{{ $pasok->id }}', '{{ $pasok->produk }}')"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit-pasok"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i></button>
                                                            <button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_pasok_lng('{{ $pasok->id }}')"
                                                                data-bs-target="#lihat-pasok-lng"
                                                                data-id="{{ $pasok->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button>
                                                        </center>
                                                        <?php 
                                            } ?>
                                                    </td>
                                                    <td>{{ $pasok->volume }}</td>
                                                    <td>{{ $pasok->satuan }}</td>
                                                    <td>{{ $pasok->satuan_harga_gas }} {{ $pasok->harga_gas }}</td>

                                                </tr>
                                            @endforeach
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row"></div>
            @endif



        </div>
    </div>

    <script>
        document.querySelector('.btn-primary').addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    </script>
@endsection
