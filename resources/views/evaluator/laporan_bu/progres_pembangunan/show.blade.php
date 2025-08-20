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
                    <li class="breadcrumb-item text-muted">Progre Pembangunan</li>
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
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/laporan/progres-pembangunan')}}"
                                    class="btn btn-danger waves-effect waves-light">
                                    <i class='bi bi-arrow-left'></i> Kembali
                                </a>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update">
                                    <i class='bi bi-funnel'></i> Update Status
                                </button>

                                <button type="button"
                                    class="btn btn-info waves-effect waves-light btn-selesai-status">
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
                                                <div id="kt_modal_update_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                
                                            <form action="{{ url('/laporan/progres-pembangunan/update-revision-all') }}"
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
                                <input type="hidden" class="export-title" value="Laporan Progres Pembangunan" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th style="text-align: center; vertical-align: middle;">No</th>
                                    <th style="text-align: center; vertical-align: middle;">Nama Perusahaan</th>
                                    <th style="text-align: center; vertical-align: middle;">Status</th>
                                    <th style="text-align: center; vertical-align: middle;">Catatan</th>
                                    <th style="text-align: center; vertical-align: middle;">Aksi</th>
                                    <th style="text-align: center; vertical-align: middle;">Prosentase Pembangunan</th>
                                    <th style="text-align: center; vertical-align: middle;">Realisasi Investasi</th>
                                    <th style="text-align: center; vertical-align: middle;">Matrik bobot Pembangunan</th>
                                    <th style="text-align: center; vertical-align: middle;">Path Matrik Bobot Pembangunan</th>
                                    <th style="text-align: center; vertical-align: middle;">Bukti Progres Pembangunan</th>
                                    <th style="text-align: center; vertical-align: middle;">Path Bukti Progres Pembangunan</th>
                                    <th style="text-align: center; vertical-align: middle;">Tkdn</th>
                                    <th style="text-align: center; vertical-align: middle;">Status</th>
                                    <th style="text-align: center; vertical-align: middle;">Petugas</th>
                                    <th style="text-align: center; vertical-align: middle;">Tgl Dibuat Laporan</th>
                                    <th style="text-align: center; vertical-align: middle;">Tgl Pengajuan Laporan</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($query as $pp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pp->nama_perusahaan }}</td>
                                        <td>
                                            @if ($pp->status == 1 && $pp->catatan)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($pp->status == 1)
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($pp->status == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($pp->status == 3)
                                                <span class="badge bg-primary">Selesai</span>
                                            @elseif ($pp->status == 0)
                                                <span class="badge bg-info">draf</span>
                                            @endif
                                        </td>
                                        <td>{{ $pp->catatan }}</td>
                                        <td class="text-center">
                                            @if ($pp->status == 1)
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-info btn-update mb-2"
                                                    data-bs-toggle="modal" data-bs-target="#modal-update"
                                                    title="Revisi data">
                                                    <i class="ki-solid ki-pencil align-middle"></i>
                                                </button>
                                                @if ($pp->status == 1 && $pp->catatan)
                                                    <button
                                                        class="btn btn-primary btn-icon btn-sm btn-selesai"
                                                        data-id="{{ $pp->id }}"><i class="bi bi-check-lg"
                                                            title="Selesai"></i></button>
                                                @endif

                                                <div class="modal fade" id="modal-update"
                                                    data-bs-backdrop="static" data-bs-keyboard="false"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="staticBackdropLabel">Update
                                                                    Status</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ url('/laporan/progres-pembangunan/update-revision') }}"
                                                                method="post" id="updateStatusForm"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ \Illuminate\Support\Facades\Crypt::encrypt($pp->id) }}">
                                                                <div class="modal-body">
                                                                    <label for="catatan">Notes</label>
                                                                    <textarea name="catatan" id="catatan" cols="5" rows="5" class="form-control"></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $pp->prosentase_pembangunan }}</td>
                                        <td>{{ $pp->realisasi_investasi }}</td>
                                        <td>{{ $pp->matrik_bobot_pembangunan }}</td>
                                        <td>{{ $pp->path_matrik_bobot_pembangunan }}</td>
                                        <td>{{ $pp->bukti_progres_pembangunan }}</td>
                                        <td>{{ $pp->path_bukti_progres_pembangunan }}</td>
                                        <td>{{ $pp->tkdn }}</td>
                                        <td>{{ $pp->status }}</td>
                                        <td>{{ $pp->petugas }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pp->created_at)->format('Y-m-d') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pp->tgl_kirim)->format('Y-m-d') }}</td>
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
                            url: '{{ url('/laporan/progres-pembangunan/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
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
                            url: '{{ url('/laporan/progres-pembangunan/selesai-periode') }}',
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
