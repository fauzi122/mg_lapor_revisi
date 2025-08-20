@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">{{ $title }}</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Laporan Badan Usaha</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        {{-- <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
            <i class="mdi mdi-alert-circle-outline label-icon"></i>
            <strong>Informasi:</strong> Data yang ditampilkan merupakan informasi perusahaan berdasarkan nomor izin yang
            telah mengajukan laporan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}
        <div class="card-body mt-4">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-flex btn-success h-40px fs-7 fw-bold"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                <i class='bi-printer-fill'></i>
                                Cetak
                                </button>
                                <a href="{{ url('/laporan/progres-pembangunan/lihat-semua-data') }}"
                                    class="btn btn-flex btn-info h-40px fs-7 fw-bold">
                                    <i class='bi-card-list'></i>
                                    Lihat Semua Data
                                </a>

                                {{-- Modal cetak --}}
                                <div class="modal fade modal-select bs-example-modal-center" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cetak</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="cetakForm" action="{{ url('/laporan/progres-pembangunan/cetak-periode') }}" method="post">
                                                    @csrf
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Nama
                                                                Perusahaan</label>
                                                            <select
                                                                class="form-control select20 select2-hidden-accessible mb-2"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                name="perusahaan" required>
                                                                <option value="">--Pilih Perusahaan--</option>
                                                                <option value="all">Semua Perusahaan </option>
                                                                <!-- Opsi untuk semua perusahaan -->
                                                                @foreach ($perusahaan->unique('npwp') as $p)
                                                                    <option value="{{ $p->npwp }}">
                                                                        {{ $p->nama_perusahaan }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Tanggal
                                                                Awal</label>
                                                                <input class="form-control" name="t_awal" type="date"
                                                                id="example-text-input" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Tanggal
                                                                Akhir</label>
                                                            <input class="form-control" name="t_akhir" type="date"
                                                                id="example-text-input" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <button type="submit" data-bs-dismiss="modal"
                                                                class="btn btn-primary">Proses</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="{{ $title }}" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th style="text-align: center; vertical-align: middle;">No</th>
                                    <th style="text-align: center; vertical-align: middle;">Nama Perusahaan</th>
                                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($perusahaan as $per)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $per->nama_perusahaan }}</td>
                                        <td><a href="{{ url('laporan/progres-pembangunan/' . Crypt::encryptString($per->npwp)) }}"
                                                class="btn btn-primary btn-rounded btn-sm"><i
                                                    class="bi-eye fs-3"></i> Lihat </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection