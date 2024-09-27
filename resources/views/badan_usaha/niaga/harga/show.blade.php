@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Harga</h4>
                    </div>
                </div>
            </div>
            {{-- Harga BBM JBU/Hasil Olahan/Minyak Bumi --}}
            @if ($statushargabbmjbux != '' and $hargax == 'bbmjbu')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Harga BBM JBU/Hasil Olahan/Minyak Bumi
                                    </h5>
                                    <div>
                                        <a href="/niaga/harga"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        <form action="/submit_bulan_harga-bbm-jbu/{{ $bulan_ambil_hargabbmjbux . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $statushargabbmjbux == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal"
                                            onclick="produk('BBM'); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_hargabbmjbux }}');"
                                            data-bs-target="#input_HargaBBM"
                                            {{ $statushargabbmjbux == 1 || $statushargabbmjbux == 2 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_hargabbmjbux) }}
                                        </button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#excelhbjbu"
                                            {{ $statushargabbmjbux == 1 || $statushargabbmjbux == 2 ? 'disabled' : '' }}
                                            onclick="tambahPMB('{{ $bulan_ambil_hargabbmjbux }}')">Import Excel
                                        </button>
                                        @include('badan_usaha.niaga.harga.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Sektor</th>
                                                <th>Produk</th>
                                                <th>Provinsi</th>
                                                <th>Komponen Harga (Rp/KL)</th>
                                                <th>Volume (KL)</th>
                                                <th>Harga Jual (Rp/KL)</th>
                                                <th>Formula</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hargabbmjbu as $hargabbmjbu)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ dateIndonesia($hargabbmjbu->bulan) }}</td>
                                                    <td>{{ $hargabbmjbu->sektor }}</td>
                                                    <td>{{ $hargabbmjbu->produk }}</td>
                                                    <td>{{ $hargabbmjbu->provinsi }}</td>
                                                    <td>
                                                        <h6>Biaya Perolehan : <span class="text-info">{{ $hargabbmjbu->biaya_perolehan }}</span></h6>
                                                        <h6>Biaya Distribusi : <span class="text-info">{{ $hargabbmjbu->biaya_distribusi }}</span></h6>
                                                        <h6>Biaya Penyimpanan : <span class="text-info">{{ $hargabbmjbu->biaya_penyimpanan }}</span></h6>
                                                        <h6>Margin : <span class="text-info">{{ $hargabbmjbu->margin }}</span></h6>
                                                        <h6>PPN : <span class="text-info">{{ $hargabbmjbu->ppn }}</span></h6>
                                                        <h6>PBBKP : <span class="text-info">{{ $hargabbmjbu->pbbkp }}</span></h6>
                                                    </td>
                                                    <td>{{ $hargabbmjbu->volume }}</td>
                                                    <td>{{ $hargabbmjbu->harga_jual }}</td>
                                                    <td>{{ $hargabbmjbu->formula_harga }}</td>
                                                    <td>{{ $hargabbmjbu->keterangan }}</td>
                                                    <td>
                                                        @if ($hargabbmjbu->status == 1 && $hargabbmjbu->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($hargabbmjbu->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($hargabbmjbu->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($hargabbmjbu->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $hargabbmjbu->catatan }}</td>
                                                    <td>
                                                        @if ($hargabbmjbu->status == '0' || $hargabbmjbu->status == '-' || $hargabbmjbu->status == '')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info editHarga"
                                                                    onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-hargabbm"
                                                                    data-id="{{ $hargabbmjbu->id }}">
                                                                    <i class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="/submit_harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            </center>
                                                        @elseif($hargabbmjbu->status == '1')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info"
                                                                    id="" data-bs-toggle="modal"
                                                                    data-bs-target="#lihat-harga-bbm"
                                                                    onclick="lihatHargaBBM('{{ $hargabbmjbu->id }}')"
                                                                    data-id="{{ $hargabbmjbu->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif($hargabbmjbu->status == '2')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info editHarga"
                                                                    onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-hargabbm"
                                                                    data-id="{{ $hargabbmjbu->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/submit_harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            </center>
                                                        @endif

                                                        <center>
                                                            @if ($hargabbmjbu->status == 1 && $hargabbmjbu->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($hargabbmjbu->status == 1)
                                                                <span class="badge bg-success">Kirim</span>
                                                            @elseif ($hargabbmjbu->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $hargabbmjbu->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>

                                                    </td>
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

            {{-- Harga LPG --}}
            @if ($statushargalpgx != '' and $hargax == 'hargalpg')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Harga LPG
                                    </h5>
                                    <div>
                                        <a href="/niaga/harga"
                                            class="btn btn-secondary waves-effect waves-light">Kembali</a>
                                        <form action="/submitbulanHargaLPG/{{ $bulan_ambil_hargalpgx . '-01' }}"
                                            method="post" class="d-inline">
                                            @method('put')
                                            @csrf
                                            <button type="button" class="btn btn-info"
                                                onclick="kirimData($(this).closest('form'))"
                                                {{ $statushargalpgx == 1 ? 'disabled' : '' }}>
                                                <span title="Kirim semua data">Kirim Semua</span>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal"
                                            onclick="produk(); provinsi(); sektor(); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                            data-bs-target="#inputHargaLPG"
                                            {{ $statushargalpgx == 1 || $statushargalpgx == 2 ? 'disabled' : '' }}>Buat
                                            Laporan {{ dateIndonesia($bulan_ambil_hargalpgx) }}</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            data-bs-toggle="modal" onclick="tambahPMB('{{ $bulan_ambil_hargalpgx }}')"
                                            data-bs-target="#excelHargaLPG"
                                            {{ $statushargalpgx == 1 || $statushargalpgx == 2 ? 'disabled' : '' }}>Import
                                            Excel</button>

                                        @include('badan_usaha.niaga.harga.modal')
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Sektor</th>
                                                <th>Provinsi</th>
                                                <th>Komponen Harga</th>
                                                <th>Kabupaten / Kota</th>
                                                <th>Volume</th>
                                                <th>Harga Jual</th>
                                                {{-- <th>Biaya Perolehan</th> --}}
                                                {{-- <th>Biaya Distribusi</th> --}}
                                                {{-- <th>Biaya Penyimpanan</th> --}}
                                                {{-- <th>Margin</th> --}}
                                                {{-- <th>PPN</th> --}}
                                                <th>Formula</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hargalpg as $hargaLPG)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ dateIndonesia($hargaLPG->bulan) }}</td>
                                                    <td>{{ $hargaLPG->sektor }}</td>
                                                    <td>{{ $hargaLPG->provinsi }}</td>
                                                    <td>
                                                        <h6>Biaya Perolehan : <span class="text-info">{{ $hargaLPG->biaya_perolehan }}</span></h6>
                                                        <h6>Biaya Distribusi : <span class="text-info">{{ $hargaLPG->biaya_distribusi }}</span></h6>
                                                        <h6>Biaya Penyimpanan : <span class="text-info">{{ $hargaLPG->biaya_penyimpanan }}</span></h6>
                                                        <h6>Margin : <span class="text-info">{{ $hargaLPG->margin }}</span></h6>
                                                        <h6>PPN : <span class="text-info">{{ $hargaLPG->ppn }}</span></h6>
                                                    </td>
                                                    <td>{{ $hargaLPG->kabupaten_kota }}</td>
                                                    <td>{{ $hargaLPG->volume }}</td>
                                                    <td>{{ $hargaLPG->harga_jual }}</td>
                                                    <td>{{ $hargaLPG->formula_harga }}</td>
                                                    <td>{{ $hargaLPG->keterangan }}</td>
                                                    <td>
                                                        @if ($hargaLPG->status == 1 && $hargaLPG->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($hargaLPG->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($hargaLPG->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($hargaLPG->status == 0)
                                                            <span class="badge bg-info">draf</span>
                                                        @endif
                                                        {{ $hargaLPG->catatan }}
                                                    </td>
                                                    <td>
                                                        @if ($hargaLPG->status == '0' || $hargaLPG->status == '-' || $hargaLPG->status == '')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga"
                                                                    onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}'); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#editHargaLPG"
                                                                    data-id="{{ $hargaLPG->id }}">
                                                                    <i class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/hapusHargaLPG/{{ $hargaLPG->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="hapusData($(this).closest('form'))">
                                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="/submitHargaLPG/{{ $hargaLPG->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            </center>
                                                        @elseif($hargaLPG->status == '1')
                                                            <center>
                                                                <button type="button" class="btn btn-sm btn-info"
                                                                    id="" data-bs-toggle="modal"
                                                                    data-bs-target="#lihat-harga-lpg"
                                                                    onclick="lihatHargaLPG('{{ $hargaLPG->id }}')"
                                                                    data-id="{{ $hargaLPG->id }}">
                                                                    <i class="bx bx-show-alt" title="Lihat data"></i>
                                                                </button>
                                                            </center>
                                                        @elseif($hargaLPG->status == '2')
                                                            <center>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info editHarga"
                                                                    onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}'); tambahPMB('{{ $bulan_ambil_hargalpgx }}');"
                                                                    id="editharga" data-bs-toggle="modal"
                                                                    data-bs-target="#editHargaLPG"
                                                                    data-id="{{ $hargaLPG->id }}"> <i
                                                                        class="bx bx-edit-alt" title="Edit data"></i>
                                                                </button>
                                                                <form action="/submitHargaLPG/{{ $hargaLPG->id }}"
                                                                    method="post" class="d-inline">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="kirimData($(this).closest('form'))">
                                                                        <i class="bx bx-paper-plane"
                                                                            title="Kirim data"></i>
                                                                    </button>
                                                                </form>
                                                            </center>
                                                        @endif

                                                        <center>
                                                            @if ($hargaLPG->status == 1 && $hargaLPG->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($hargaLPG->status == 1)
                                                                <span class="badge bg-success">Kirim</span>
                                                            @elseif ($hargaLPG->status == 2)
                                                                <span class="badge bg-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-updateStatus-{{ $hargaLPG->id }}">
                                                                    Cek Revisi
                                                                </span>
                                                            @endif
                                                        </center>

                                                    </td>
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
    {{--  <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
@endsection
