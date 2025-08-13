@extends('layouts.blackand.app')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h3 class="text-dark fw-bold">{{ $per->nama_perusahaan }}</h3>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Minyak Bumi</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">{{ $title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if ($query)
        <div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0" role="alert">
                    <i class="mdi mdi-alert-circle-outline label-icon"></i>
                    <strong>Informasi:</strong> Data yang ditampilkan di halaman ini adalah data untuk bulan berjalan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="card-body mt-4">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header bg-light p-5">
                            <div class="row w-100">
                                <div class="col-12">
                                    <div class="d-flex justify-content-start">
                                        <h4>
                                            @if ($mode === 'tahun')
                                                Periode Tahun {{ getTahun($per->bulan) }} -
                                                {{ $per->nama_perusahaan ?? '-' }}
                                            @else
                                                Periode Bulan {{ dateIndonesia($per->bulan) }} -
                                                {{ $per->nama_perusahaan ?? '-' }}
                                            @endif
                                        </h4>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ url('laporan/penyimpanan/mb/periode') . '/' . \Illuminate\Support\Facades\Crypt::encrypt($per->npwp) }}"
                                            class="btn btn-danger waves-effect waves-light">
                                            <i class='bi bi-arrow-left'></i> Kembali
                                        </a>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update">
                                            <i class='bi bi-funnel'></i> Update Status
                                        </button>

                                        <button type="button" class="btn btn-info waves-effect waves-light">
                                            <i class="bi bi-check-lg"></i> Selesai
                                        </button>

                                        <div class="modal fade" id="kt_modal_update" tabindex="-1" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content rounded">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header" id="kt_modal_update_header">
                                                        <!--begin::Modal title-->
                                                        <h2 class="fw-bold">Update Status</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div id="kt_modal_update_close"
                                                            class="btn btn-icon btn-sm btn-active-icon-primary"
                                                            data-bs-dismiss="modal">
                                                            <i class="ki-outline ki-cross fs-1"></i>
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>

                                                    <form action="{{ url('/laporan/penyimpanan/mb/update-revision-all') }}"
                                                        method="post" id="updateStatusForm" enctype="multipart/form-data">
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

                                                                <input type="hidden" name="p"
                                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($per->npwp) }}">
                                                                <input type="hidden" name="b"
                                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($per->bulan) }}">
                                                                <div class="modal-body">
                                                                    <label for="catatan">Notes</label>
                                                                    <textarea name="catatan" id="catatan" cols="5" rows="5" class="form-control"></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Update
                                                                    </button>
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
                                        <input type="hidden" class="export-title"
                                            value="Laporan Penyimpanan Minyak Bumi {{ dateIndonesia($per->bulan) }} {{ $per->nama_perusahaan }}" />
                                    </div>
                                </div>
                                <table class="kt-datatable table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr class="fw-bold text-uppercase">
                                            <th style="text-align: center; vertical-align: middle;">No</th>
                                            <th style="text-align: center; vertical-align: middle;">Bulan</th>
                                            <th style="text-align: center; vertical-align: middle;">Tahun</th>
                                            <th style="text-align: center; vertical-align: middle;">Status</th>
                                            <th style="text-align: center; vertical-align: middle;">Catatan</th>
                                            <th style="text-align: center; vertical-align: middle;">No Tangki</th>
                                            <th style="text-align: center; vertical-align: middle;">Aksi</th>
                                            <th style="text-align: center; vertical-align: middle;">Produk</th>
                                            <th style="text-align: center; vertical-align: middle;">Kab/Kota</th>
                                            <th style="text-align: center; vertical-align: middle;">Jenis Komoditas</th>
                                            <th style="text-align: center; vertical-align: middle;">Kapasitas Tangki</th>
                                            <th style="text-align: center; vertical-align: middle;">Volume Awal</th>
                                            <th style="text-align: center; vertical-align: middle;">Volume Supply</th>
                                            <th style="text-align: center; vertical-align: middle;">Volume Output</th>
                                            <th style="text-align: center; vertical-align: middle;">Volume Stok Akhir</th>
                                            <th style="text-align: center; vertical-align: middle;">Satuan</th>
                                            <th style="text-align: center; vertical-align: middle;">Utilisasi Tangki</th>
                                            
                                            <th style="text-align: center; vertical-align: middle;">Pengguna</th>
                                            <th style="text-align: center; vertical-align: middle;">Tarif Penyimpanan</th>
                                            <th style="text-align: center; vertical-align: middle;">Satuan Tarif</th>
                                            <th style="text-align: center; vertical-align: middle;">Keterangan</th>
                                            <th style="text-align: center; vertical-align: middle;">Tanggal Awal</th>
                                            <th style="text-align: center; vertical-align: middle;">Tanggal Akhir</th>
                                            <th style="text-align: center; vertical-align: middle;">Commingle</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah BU</th>
                                            <th style="text-align: center; vertical-align: middle;">Nama Penyewa</th>
                                            <th style="text-align: center; vertical-align: middle;">Kapasitas Penyewaan
                                            </th>
                                            <th style="text-align: center; vertical-align: middle;">Kontrak Sewa</th>
                                            <th style="text-align: center; vertical-align: middle;">Tgl Dibuat Laporan</th>
                                            <th style="text-align: center; vertical-align: middle;">Tgl Pengajuan Laporan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($query as $pgb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ getBulan($pgb->bulan) }}</td>
                                                <td>{{ getTahun($pgb->bulan) }}</td>
                                                <td>
                                                    @if ($pgb->status == 1 && $pgb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pgb->status == 1)
                                                        <span class="badge bg-success">Diterima</span>
                                                    @elseif ($pgb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pgb->status == 3)
                                                        <span class="badge bg-primary">Selesai</span>
                                                    @elseif ($pgb->status == 0)
                                                        <span class="badge bg-info">Draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pgb->catatan }}</td>
                                                <td>{{ $pgb->no_tangki }}</td>
                                                <td>
                                                    @if ($pgb->status == 1)
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-info btn-update"
                                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_{{ $pgb->id }}"
                                                            title="Revisi data">
                                                            <i class="ki-solid ki-pencil align-middle"></i>
                                                        </button>

                                                        @if ($pgb->status == 1 && $pgb->catatan)
                                                            <button class="btn btn-primary btn-icon btn-sm btn-selesai"
                                                                data-id="{{ $pgb->id }}">
                                                                <i class="bi bi-check-lg" title="Selesai"></i>
                                                            </button>
                                                        @endif

                                                        <div class="modal fade" id="kt_modal_update_{{ $pgb->id }}" tabindex="-1"
                                                            aria-hidden="true">
                                                            <!--begin::Modal dialog-->
                                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                                <!--begin::Modal content-->
                                                                <div class="modal-content rounded">
                                                                    <!--begin::Modal header-->
                                                                    <div class="modal-header" id="kt_modal_update_header">
                                                                        <!--begin::Modal title-->
                                                                        <h2 class="fw-bold">Update Status</h2>
                                                                        <!--end::Modal title-->
                                                                        <!--begin::Close-->
                                                                        <div id="kt_modal_update_close"
                                                                            class="btn btn-icon btn-sm btn-active-icon-primary"
                                                                            data-bs-dismiss="modal">
                                                                            <i class="ki-outline ki-cross fs-1"></i>
                                                                        </div>
                                                                        <!--end::Close-->
                                                                    </div>

                                                                    <form
                                                                        action="{{ url('/laporan/penyimpanan/mb/update-revision') }}"
                                                                        method="post" id="updateStatusForm"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-body py-3 px-lg-17">
                                                                            <!--begin::Scroll-->
                                                                            <div class="scroll-y me-n7 pe-7"
                                                                                id="kt_modal_new_target_scroll"
                                                                                data-kt-scroll="true"
                                                                                data-kt-scroll-activate="{default: false, lg: true}"
                                                                                data-kt-scroll-max-height="auto"
                                                                                data-kt-scroll-dependencies="#kt_modal_new_target_header"
                                                                                data-kt-scroll-wrappers="#kt_modal_new_target_scroll"
                                                                                data-kt-scroll-offset="300px">

                                                                                <div class="fv-row mb-7">
                                                                                    <input type="hidden" name="id"
                                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($pgb->id) }}">
                                                                                </div>
                                                                                <div class="fv-row mb-7">
                                                                                    <label for="catatan"
                                                                                        class="d-flex align-items-center fs-6 fw-semibold mb-2">Notes</label>
                                                                                    <textarea name="catatan" id="catatan" cols="5" rows="5" class="form-control"></textarea>
                                                                                </div>

                                                                                <div class="modal-footer flex-center">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Update</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
                                                    @endif
                                                </td>
                                                <td>{{ $pgb->produk }}</td>
                                                <td>{{ $pgb->kab_kota }}</td>
                                                <td>{{ is_array(json_decode($pgb->jenis_komoditas, true)) ? implode(', ', json_decode($pgb->jenis_komoditas, true)) : $pgb->jenis_komoditas }}
                                                </td>
                                                <td>{{ $pgb->kapasitas_tangki }}</td>
                                                <td>{{ $pgb->volume_stok_awal }}</td>
                                                <td>{{ $pgb->volume_supply }}</td>
                                                <td>{{ $pgb->volume_output }}</td>
                                                <td>{{ $pgb->volume_stok_akhir }}</td>
                                                <td>{{ $pgb->satuan }}</td>
                                                <td>{{ $pgb->utilisasi_tangki }}</td>
                                                
                                                <td>{{ $pgb->pengguna }}</td>
                                                <td>{{ $pgb->tarif_penyimpanan }}</td>
                                                <td>{{ $pgb->satuan_tarif }}</td>
                                                <td>{{ $pgb->keterangan }}</td>
                                                <td>{{ $pgb->tanggal_awal }}</td>
                                                <td>{{ $pgb->tanggal_akhir }}</td>
                                                <td>{{ $pgb->commingle }}</td>
                                                <td>{{ $pgb->jumlah_bu }}</td>
                                                <td>{{ $pgb->nama_penyewa }}</td>
                                                <td>{{ $pgb->kapasitas_penyewaan }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($pgb->kontrak_sewa) }}"
                                                        class="btn btn-success" download="">
                                                        <i class="bi bi-download"></i> Unduh
                                                    </a>
                                                </td>
                                                {{-- <td>{{ $pgb->kontrak_sewa }}</td> --}}
                                                <td>{{ \Carbon\Carbon::parse($pgb->created_at)->format('d F Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($pgb->tgl_kirim)->format('d F Y') }}
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
    @endif

    {{-- <div class="page-content">
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <h4>{{ $per->nama_perusahaan }}</h4>

                        </div>

                    </div>
                </div>
            </div>

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode Bulan {{ dateIndonesia($per->bulan) }}</h4>

                                    <div>
                                        <a href="{{ url('laporan/penyimpanan/mb/periode') . '/' . \Illuminate\Support\Facades\Crypt::encrypt($per->npwp) }}"
                                            class="btn btn-danger btn-sm btn-rounded"><i class='bx bx-arrow-back'></i>
                                            Kembali</a>
                                        <button type="button" class="btn btn-info btn-sm rounded-pill btn-update-status"
                                            data-bs-toggle="modal" data-bs-target="#modal-update-status">
                                            <i class="bx bxs-edit align-middle"></i> Update Status
                                        </button>



                                        <button type="button"
                                            class="btn btn-primary btn-sm rounded-pill btn-selesai-status">
                                            <i class="bx bx-check"></i> Selesai
                                        </button>


                                        <div class="modal fade" id="modal-update-status" data-bs-backdrop="static"
                                            data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Update
                                                            Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ url('/laporan/penyimpanan/mb/update-revision-all') }}"
                                                        method="post" id="updateStatusForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="p"
                                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($per->npwp) }}">
                                                        <input type="hidden" name="b"
                                                            value="{{ \Illuminate\Support\Facades\Crypt::encrypt($per->bulan) }}">
                                                        <div class="modal-body">
                                                            <label for="catatan">Notes</label>
                                                            <textarea name="catatan" id="catatan" cols="5" rows="5" class="form-control"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <div style="overflow-x: auto;">
                                        <table id="datatable-buttons" class="table w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Bulan</th>
                                                    <th>Tahun</th>
                                                    <th>Status</th>
                                                    <th>Catatan</th>
                                                    <th>No Tangki</th>
                                                    <th>Produk</th>
                                                    <th>Kab/Kota</th>
                                                    <th>Jenis Komoditas</th>
                                                    <th>Kapasitas Tangki</th>
                                                    <th>Volume Awal</th>
                                                    <th>Volume Supply</th>
                                                    <th>Volume Output</th>
                                                    <th>Volume Stok Akhir</th>
                                                    <th>Satuan</th>
                                                    <th>Utilisasi Tangki</th>
                                                    <th>Aksi</th>
                                                    <th>Pengguna</th>
                                                    <th>Tarif Penyimpanan</th>
                                                    <th>Satuan Tarif</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal Awal</th>
                                                    <th>Tanggal Akhir</th>
                                                    <th>Commingle</th>
                                                    <th>Jumlah BU</th>
                                                    <th>Nama Penyewa</th>
                                                    <th>Kapasitas Penyewaan</th>
                                                    <th>Kontrak Sewa</th>
                                                    <th>Tgl Dibuat Laporan</th>
                                                    <th>Tgl Pengajuan Laporan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($query as $pgb)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ getBulan($pgb->bulan) }}</td>
                                                        <td>{{ getTahun($pgb->bulan) }}</td>
                                                        <td>
                                                            @if ($pgb->status == 1 && $pgb->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($pgb->status == 1)
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif ($pgb->status == 2)
                                                                <span class="badge bg-danger">Revisi</span>
                                                            @elseif ($pgb->status == 3)
                                                                <span class="badge bg-primary">Selesai</span>
                                                            @elseif ($pgb->status == 0)
                                                                <span class="badge bg-info">Draf</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $pgb->id }}</td>
                                                        <td>{{ $pgb->no_tangki }}</td>
                                                        <td>{{ $pgb->produk }}</td>
                                                        <td>{{ $pgb->kab_kota }}</td>
                                                        <td>{{ is_array(json_decode($pgb->jenis_komoditas, true)) ? implode(', ', json_decode($pgb->jenis_komoditas, true)) : $pgb->jenis_komoditas }}
                                                        </td>
                                                        <td>{{ $pgb->kapasitas_tangki }}</td>
                                                        <td>{{ $pgb->volume_stok_awal }}</td>
                                                        <td>{{ $pgb->volume_supply }}</td>
                                                        <td>{{ $pgb->volume_output }}</td>
                                                        <td>{{ $pgb->volume_stok_akhir }}</td>
                                                        <td>{{ $pgb->satuan }}</td>
                                                        <td>{{ $pgb->utilisasi_tangki }}</td>
                                                        <td>
                                                            @if ($pgb->status == 1)
                                                                <button type="button"
                                                                    class="btn btn-info btn-sm rounded-pill btn-update"
                                                                    data-bs-toggle="modal" data-bs-target="#modal-update"
                                                                    title="Revisi data">
                                                                    <i class="bx bxs-edit align-middle"></i>
                                                                </button>

                                                                @if ($pgb->status == 1 && $pgb->catatan)
                                                                    <button
                                                                        class="btn btn-primary btn-rounded btn-sm btn-selesai"
                                                                        data-id="{{ $pgb->id }}">
                                                                        <i class="bx bx-check" title="Selesai"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $pgb->pengguna }}</td>
                                                        <td>{{ $pgb->tarif_penyimpanan }}</td>
                                                        <td>{{ $pgb->satuan_tarif }}</td>
                                                        <td>{{ $pgb->keterangan }}</td>
                                                        <td>{{ $pgb->tanggal_awal }}</td>
                                                        <td>{{ $pgb->tanggal_akhir }}</td>
                                                        <td>{{ $pgb->commingle }}</td>
                                                        <td>{{ $pgb->jumlah_bu }}</td>
                                                        <td>{{ $pgb->nama_penyewa }}</td>
                                                        <td>{{ $pgb->kapasitas_penyewaan }}</td>
                                                        <td>{{ $pgb->kontrak_sewa }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($pgb->created_at)->format('d F Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($pgb->tgl_kirim)->format('d F Y') }}
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
            @endif
        </div>
    </div> --}}
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-selesai-status').on('click', function() {
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menyelesaikan periode ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, selesaikan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('/laporan/penyimpanan/mb/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                b: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->bulan) }}',
                                p: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->npwp) }}'
                            },
                            success: function(response) {
                                Swal.fire('Status diperbarui!',
                                        'Periode telah diselesaikan.', 'success')
                                    .then(function() {
                                        location.reload();
                                    });
                            },
                            error: function(error) {
                                Swal.fire('Gagal',
                                    'Terjadi kesalahan saat memperbarui status.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>


    <script>
        document.querySelectorAll('.btn-selesai').forEach(function(button) {
            // Menambahkan event listener ke setiap elemen button
            button.addEventListener('click', function() {
                // Mengambil nilai id dari atribut data-id
                var id = this.getAttribute('data-id');

                console.log('cek id =', id);

                // Show SweetAlert confirmation
                Swal.fire({
                    title: 'Apakah Anda yakin ingin menyelesaikan periode ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, selesaikan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    // If the user clicks 'Yes', trigger your update logic
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('/laporan/penyimpanan/mb/selesai-periode') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id, // Menggunakan nilai id yang diambil dari atribut data-id
                            },
                            success: function(response) {
                                // Handle the response from the server
                                // For example, show a success message
                                Swal.fire('Status diperbarui!',
                                        'Periode telah diselesaikan.', 'success')
                                    .then(function() {
                                        // Reload the page after the SweetAlert is closed
                                        location.reload();
                                    });
                            },
                            error: function(error) {
                                // Handle errors, show an error message, etc.
                                Swal.fire('Gagal',
                                    'Terjadi kesalahan saat memperbarui status.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
