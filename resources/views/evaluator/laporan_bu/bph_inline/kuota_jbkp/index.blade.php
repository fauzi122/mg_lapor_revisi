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
                        <li class="breadcrumb-item text-muted">JBKP Kuota</li>
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
            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                <i class="mdi mdi-alert-circle-outline label-icon"></i>
                <strong>Informasi:</strong> Data yang ditampilkan merupakan informasi perusahaan berdasarkan nomor izin yang
                telah mengajukan laporan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="card-body mt-4">
                <div class="card mb-5 mb-xl-8 shadow">
                    <div class="card-header bg-light p-5">
                        <div class="row w-100">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ url('/laporan/sinkronisasi-data/kuota-jbkp') }}"
                                        class="btn btn-warning waves-effect waves-light">
                                        <i class='bi bi-arrow-repeat fs-1'></i> Sinkronisasi Data
                                    </a>

                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_cetak"><i
                                            class='bi-printer-fill fs-3'></i> Cetak
                                    </button>

                                    <a href="{{ url('/laporan/kuota-jbkp-lihat-semua-data') }}"
                                        class="btn btn-info waves-effect waves-light">
                                        <i class='bi bi-eye fs-1'></i>
                                        Lihat Semua Data
                                    </a>

                                    <!-- Modal Baru -->
                                    <div class="modal fade" id="kt_modal_cetak" tabindex="-1" aria-hidden="true">
                                        <!--begin::Modal dialog-->
                                        <div class="modal-dialog modal-dialog-centered mw-650px">
                                            <!--begin::Modal content-->
                                            <div class="modal-content rounded">
                                                <!--begin::Modal header-->
                                                <div class="modal-header" id="kt_modal_filter_header">
                                                    <!--begin::Modal title-->
                                                    <h2 class="fw-bold">Cetak</h2>
                                                    <!--end::Modal title-->
                                                    <!--begin::Close-->
                                                    <div id="kt_modal_filter_close"
                                                        class="btn btn-icon btn-sm btn-active-icon-primary"
                                                        data-bs-dismiss="modal">
                                                        <i class="ki-outline ki-cross fs-1"></i>
                                                    </div>
                                                    <!--end::Close-->
                                                </div>

                                                <form action="{{ url('/laporan/kuota-jbkp/cetak-periode') }}"
                                                    method="post">
                                                    @csrf
                                                    <div class="modal-body py-10 px-lg-17">
                                                        <!--begin::Scroll-->
                                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_target_scroll"
                                                            data-kt-scroll="true"
                                                            data-kt-scroll-activate="{default: false, lg: true}"
                                                            data-kt-scroll-max-height="auto"
                                                            data-kt-scroll-dependencies="#kt_modal_new_target_header"
                                                            data-kt-scroll-wrappers="#kt_modal_new_target_scroll"
                                                            data-kt-scroll-offset="300px">

                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama
                                                                    Perusahaan</label>
                                                                <select class="form-control select20 mb-2"
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
                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Tanggal Awal</span>
                                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                                        title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                                                        <i class="ki-outline ki-information fs-7"></i>
                                                                    </span>
                                                                </label>
                                                                <input class="form-control flatpickr" name="t_awal"
                                                                    required>
                                                            </div>
                                                            <div class="fv-row mb-7">
                                                                <label for="example-text-input"
                                                                    class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                                                    <span>Tanggal Akhir</span>
                                                                    <span class="ms-1" data-bs-toggle="tooltip"
                                                                        title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                                                        <i class="ki-outline ki-information fs-7"></i>
                                                                    </span>
                                                                </label>
                                                                <input class="form-control flatpickr" name="t_akhir"
                                                                    required>
                                                            </div>
                                                            <div class="modal-footer flex-center">
                                                                <button type="submit" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Proses</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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
                                    <input type="hidden" class="export-title" value="Laporan JBKP Kuota" />
                                </div>
                            </div>
                            <table class="kt-datatable table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr class="fw-bold text-uppercase">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Perusahaan</th>
                                        <th class="text-center">Nomor Izin</th>
                                        <!-- <th>Tanggal Pengajuan Izin</th>
                                                                                        <th>Tanggal Disetujui Izin</th> -->
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($perusahaan as $per)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $per->nama_badan_usaha }}</td>

                                            <td>
                                                @if (is_array($per->izin_list))
                                                    <ul style="margin: 0; padding-left: 15px;">
                                                        @foreach ($per->izin_list as $izin)
                                                            <li>ID: {{ $izin['id_izin_usaha'] }} - Nomor:
                                                                {{ $izin['nomor_izin_usaha'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">Tidak ada data</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ url('laporan/kuota-jbkp/periode/' . Crypt::encryptString($per->npwp_badan_usaha)) }}"
                                                    class="btn btn-primary btn-rounded btn-sm">
                                                    <i class="bi bi-eye fs-3"></i> Lihat
                                                </a>

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

@section('script')
@endsection
