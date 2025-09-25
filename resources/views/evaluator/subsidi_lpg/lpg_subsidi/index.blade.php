@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data LPG Subsidi Verified</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Subsidi LPG</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Data LPG Subsidi Verified</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end mb-3 gap-2">
                                <button type="button" class="btn btn-primary  btn-rounded waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_target" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Data"><i class="bi bi-file-earmark-plus fs-4"></i>Tambah Data
                                </button>

                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_new_excel" data-bs-toggle="tooltip" data-bs-placement="top" title="Import Excel"><i class="bi bi-upload fs-4"></i></i> Import Excel</button>
                            
                                <!--  Tambah Data Modal  -->
                                @include('evaluator.subsidi_lpg.lpg_subsidi.modalstor')
                                <!-- End Tambah Data Modal-->

                                <!-- Import Excel -->
                                @include('evaluator.subsidi_lpg.lpg_subsidi.modal_importExcel')
                                <!-- End Import Excel -->

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Data LPG Subsidi" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Provinsi</th>
                                    <th class="text-center">Volume</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($lpg_subsidi as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ getBulan($data->bulan) }}</td> 
                                        <td>{{ getTahun($data->bulan) }}</td>
                                        
                                        <td>{{ $data->provinsi }}</td>
                                        <td>{{ $data->volume }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning btn-rounded edit-button"
                                            data-id="{{ $data->id }}"
                                            data-bulan="{{ $data->bulan }}"
                                            data-provinsi="{{ $data->provinsi }}"
                                            data-volume="{{ $data->volume }}"
                                            data-bs-toggle="modal" data-bs-target="#editKuotaModal{{ $data->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data">
                                            <i class="fa fa-edit"></i> Edit
                                            </button>

                                            <!-- Edit Modal -->
                                            @include('evaluator.subsidi_lpg.lpg_subsidi.edit-modal')

                                            
                                            <a href="#" class="btn btn-danger btn-sm btn-rounded delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus"
                                                data-id="{{ $data->id }}" onclick="deleteItem({{ $data->id }})">
                                                <i class='bi bi-trash3-fill'></i> Hapus
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
<script>
    var isLocalhost =
        window.location.hostname === "mg_lapor_revisi.test" ||
        window.location.hostname === "127.0.0.1" ||
        window.location.hostname === "localhost" ||
        window.location.hostname.endsWith("duniasakha.com");

    var baseUrl = isLocalhost ? "/" : "/pelaporan-hilir/";

    // ================= DELETE =================
    function deleteItem(itemId) {
        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan tindakan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: baseUrl + 'lpg/subsidi/delete/' + itemId, // tanpa slash ganda
                    type: 'post',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    success: function () {
                        Swal.fire({
                            title: 'Dihapus!',
                            text: 'Item telah dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus item.', 'error');
                    }
                });
            }
        });
    }

    // ================= EDIT =================
    $(document).ready(function () {
        $('.edit-button').on('click', function () {
            var kuotaId = $(this).data('id');
            var bulan = $(this).data('bulan');
            var provinsi = $(this).data('provinsi');
            var volume = $(this).data('volume');

            $('#editBulan').val(bulan);
            $('#editProvinsi').val(provinsi);
            $('#editVolume').val(volume);

            // kalau mau set action form:
            // $('#editKuotaForm').attr('action', baseUrl + 'lpg/kuota/update/' + kuotaId);

            $('#editKuotaModal').modal('show');
        });
    });
</script>
@endsection


