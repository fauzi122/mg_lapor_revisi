@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Izin Sementara</h4>
                    </div>
                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-3"
                        role="alert">
                        <i class="mdi mdi-alert-circle-outline label-icon"></i>
                        <strong>Informasi:</strong> Nomor izin yang anda laporkan adalah <b>{{ $pecah[1] }}</b>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            {{-- Izin Sementara --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Minyak Bumi / Gas Bumi</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi(); negara();" data-bs-toggle="modal"
                                        data-bs-target="#myModal">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.progres_pembangunan.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Prosentase Pembangunan</th>
                                            <th>Realisasi Invenstasi</th>
                                            <th>Matrik Bobot Pembangunan</th>
                                            <th>Bukti Progres Pembangunan</th>
                                            <th>TKDN</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ProgresPembangunan as $ProgresPembangunan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ProgresPembangunan->prosentase_pembangunan }}</td>
                                                <td>{{ $ProgresPembangunan->realisasi_investasi }}</td>
                                                <td>{{ $ProgresPembangunan->matrik_bobot_pembangunan }}</td>
                                                <td>{{ $ProgresPembangunan->bukti_progres_pembangunan }}</td>
                                                <td>{{ $ProgresPembangunan->tkdn }}</td>
                                                <td>
                                                    @if ($ProgresPembangunan->status == '0')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editlgpsub"
                                                                id="editCompany"
                                                                onclick="edit_lgpsub('{{ $ProgresPembangunan->id }}' )"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $ProgresPembangunan->id }}"> <i
                                                                    class="bx bx-edit-alt" title="Edit data"></i>
                                                            </button>
                                                            <form
                                                                action="{{ url('/hapus_lgpsub') }}/{{ $ProgresPembangunan->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ url('/submit_lgpsub') }}/{{ $ProgresPembangunan->id }}"
                                                                method="post" class="d-inline"
                                                                data-id="{{ $ProgresPembangunan->id }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($ProgresPembangunan->status == '1')
                                                        <center><button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_lgpsub('{{ $ProgresPembangunan->id }}')"
                                                                data-bs-target="#lihat-lgpsub"
                                                                data-id="{{ $ProgresPembangunan->id }}"> <i
                                                                    class="bx bx-show-alt" title="Lihat data"></i></button>
                                                        </center>
                                                    @else
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editPenjualan"
                                                                id="editCompany"
                                                                onclick="edit_ekpor('{{ $ProgresPembangunan->id }}', '{{ $ProgresPembangunan->produk }}' , '{{ $ProgresPembangunan->negara_tujuan }}'  )"
                                                                data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                                data-id="{{ $ProgresPembangunan->id }}"> <i
                                                                    class="bx bx-edit-alt" title="Edit data"></i>
                                                            </button>
                                                            <form
                                                                action="{{ url('/submit_lgpsub') }}/{{ $ProgresPembangunan->id }}"
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
        </div>
    </div>
@endsection
