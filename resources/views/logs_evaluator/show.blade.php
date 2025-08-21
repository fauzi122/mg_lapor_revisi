@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Log Show</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Log Show</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Show</li>
                </ul>
            </div>
        </div>
    </div>
</div>

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
                            <div class="d-flex justify-content-end gap-2">
                                <a href="javascript:history.back()"
                                    class="btn btn-danger waves-effect waves-light">
                                    <i class='bi bi-arrow-left'></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Logs Show" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th style="text-align: center; vertical-align: middle;">No</th>
                                    <th style="text-align: center; vertical-align: middle;">Bulan</th>
                                    <th style="text-align: center; vertical-align: middle;">Tahun</th>
                                    <th style="text-align: center; vertical-align: middle;">Action</th>
                                    <th style="text-align: center; vertical-align: middle;">Bu Id</th>
                                    <th style="text-align: center; vertical-align: middle;">Nama Perusahaan</th>
                                    <th style="text-align: center; vertical-align: middle;">Method</th>
                                    <th style="text-align: center; vertical-align: middle;">Url</th>
                                    <th style="text-align: center; vertical-align: middle;">Ip address</th>
                                    <th style="text-align: center; vertical-align: middle;">Hostname</th>
                                    <th style="text-align: center; vertical-align: middle;">Old Properties</th>
                                    <th style="text-align: center; vertical-align: middle;">Properties</th>
                                    
                                    {{-- <th style="text-align: center; vertical-align: middle;">Produk</th>
                                    <th style="text-align: center; vertical-align: middle;">Sektor</th>
                                    <th style="text-align: center; vertical-align: middle;">Provinsi</th>
                                    <th style="text-align: center; vertical-align: middle;">Volume</th>
                                    <th style="text-align: center; vertical-align: middle;">Biaya Perolehan</th>
                                    <th style="text-align: center; vertical-align: middle;">Biaya Distribusi</th>
                                    <th style="text-align: center; vertical-align: middle;">Biaya Penyimpanan</th>
                                    <th style="text-align: center; vertical-align: middle;">Margin</th>
                                    <th style="text-align: center; vertical-align: middle;">Ppn</th>
                                    <th style="text-align: center; vertical-align: middle;">Pbbkp</th>
                                    <th style="text-align: center; vertical-align: middle;">Harga Jual</th>
                                    <th style="text-align: center; vertical-align: middle;">Formula Harga</th>
                                    <th style="text-align: center; vertical-align: middle;">Keterangan</th> --}}
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($logsShow as $show)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ getBulan($show->tanggal) }}</td>
                                        <td>{{ getTahun($show->tanggal) }}</td>
                                        <td>{{ $show->action }}</td>
                                        <td>{{ $show->bu_id }}</td>
                                        <td>{{ $show->bu_name }}</td>
                                        <td>{{ $show->method }}</td>
                                        <td>{{ $show->url }}</td>
                                        <td>{{ $show->ip_address }}</td>
                                        <td>{{ $show->hostname }}</td>
                                        <td><a href="{{ url('/logs-ev/old_properties/' . $show->id) }}" class="btn btn-primary btn-rounded btn-sm">
                                                <i class="bx bx-show bi-eye fs-5"></i> Lihat
                                            </a></td>

                                        <td><a href="{{ url('/logs-ev/properties/' . $show->id) }}" class="btn btn-primary btn-rounded btn-sm">
                                            <i class="bx bx-show bi-eye fs-5"></i> Lihat
                                        </a></td>


                                        
                                        {{-- <td>{{ $show->produk }}</td>
                                        <td>{{ $show->sektor }}</td>
                                        <td>{{ $show->provinsi }}</td>
                                        <td>{{ $show->volume }}</td>
                                        <td>{{ $show->biaya_perolehan }}</td>
                                        <td>{{ $show->biaya_distribusi }}</td>
                                        <td>{{ $show->biaya_penyimpanan }}</td>
                                        <td>{{ $show->margin }}</td>
                                        <td>{{ $show->ppn }}</td>
                                        <td>{{ $show->pbbkp }}</td>
                                        <td>{{ $show->harga_jual }}</td>
                                        <td>{{ $show->formula_harga }}</td>
                                        <td>{{ $show->keterangan }}</td> --}}
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