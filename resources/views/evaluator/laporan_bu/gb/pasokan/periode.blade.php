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
                        <li class="breadcrumb-item text-muted">Gas Bumi Pasokan Kilang</li>
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
                <div class="card-body mt-4">
                    <div class="card mb-5 mb-xl-8 shadow">
                        <div class="card-header bg-light p-5">
                            <div class="row w-100">
                                <div class="col-12">
                                    <div class="d-flex justify-content-start">
                                        <h4>{{ $per->nama_perusahaan }}</h4>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ url('laporan/pasokan/gb') }}"
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
                                        <input type="hidden" class="export-title"
                                            value="{{ $title }} {{ $per->nama_perusahaan }}" />
                                    </div>
                                </div>
                                <table class="kt-datatable table table-bordered table-hover">
                                    <thead class="bg-light">
                                        <tr class="fw-bold text-uppercase">
                                            <th style="text-align: center; vertical-align: middle;">No</th>
                                            <th style="text-align: center; vertical-align: middle;">Bulan</th>
                                            <th style="text-align: center; vertical-align: middle;">Tahun</th>
                                            <th style="text-align: center; vertical-align: middle;">Status</th>
                                            <!-- <th>Catatan</th> -->
                                            <th style="text-align: center; vertical-align: middle;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($query as $data)
                                            {{-- @php
                                        $id = Crypt::encryptString(
                                            $data->bulan . ',' .  $data->izin_id
                                        );
                                        $idTahun = Crypt::encryptString(
                                            $data->bulan  . ', tahun'. ',' .  $data->izin_id
                                        );
                                    @endphp --}}
                                            @php
                                                $kodeBulan = Crypt::encryptString(
                                                    'bulan,' .
                                                        $data->bulan .
                                                        ',' .
                                                        $data->npwp .
                                                        ',' .
                                                        $data->id_permohonan,
                                                );
                                                $kodeTahun = Crypt::encryptString(
                                                    'tahun,' .
                                                        $data->bulan .
                                                        ',' .
                                                        $data->npwp .
                                                        ',' .
                                                        $data->id_permohonan,
                                                );
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <b><a href="{{ url('/laporan/pasokan/gb') }}/{{ $kodeBulan }}">{{ getBulan($data->bulan) }}
                                                            <i class="bi bi-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td>
                                                    <b><a href="{{ url('/laporan/pasokan/gb') }}/{{ $kodeTahun }}">{{ getTahun($data->bulan) }}
                                                            <i class="bi bi-check" title="lihat data laporan"></i></a><b>
                                                </td>
                                                <td>
                                                    @if ($data->status == 1 && $data->catatan)
                                                        <span class="badge bg-warning text-white">Sudah Diperbaiki</span>
                                                    @elseif ($data->status == 1)
                                                        <span class="badge bg-success text-white">Diterima</span>
                                                    @elseif ($data->status == 2)
                                                        <span class="badge bg-danger text-white">Revisi</span>
                                                    @elseif ($data->status == 0)
                                                        <span class="badge bg-info text-white">draf</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge bg-primary text-white">Selesai</span>
                                                    @endif
                                                </td>

                                                @if ($data->status == 1)
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-info btn-update"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_{{ getBulan($data->bulan) }}"
                                                            title="Revisi data">
                                                            <i class="bi bi-pencil-fill align-middle"></i>
                                                        </button>

                                                        @if ($data->status == 1 && $data->catatan)
                                                            <button
                                                                class="btn btn-primary btn-rounded btn-sm btn-selesai-status"
                                                                data-p="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->npwp) }}"
                                                                data-b="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->bulan) }}"><i
                                                                    class="bi bi-check" title="Selesai"></i>
                                                            </button>
                                                        @endif


                                                        <div class="modal fade"
                                                            id="kt_modal_update_{{ getBulan($data->bulan) }}"
                                                            tabindex="-1" aria-hidden="true">
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
                                                                        action="{{ url('/laporan/pasokan/gb/update-revision-all') }}"
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
                                                                                    <input type="hidden" name="p"
                                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->npwp) }}">
                                                                                    <input type="hidden" name="b"
                                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->bulan) }}">
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
                                                    </td>
                                                @else
                                                    <td>

                                                    </td>
                                                @endif
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



            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ $per->NAMA_PERUSAHAAN }}</h4>
                                    <div>
                                        <a href="{{ url('laporan/pasokan/gb') }}"
                                            class="btn btn-danger btn-sm btn-rounded"><i class='bx bx-arrow-back'></i>
                                            Kembali</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="penjualan">
                                        <div class="table-responsive">
                                            <table id="datatable-buttons" class="table table-bordered nowrap w-100">
                                                <thead>
                                                    <tr>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Bulan</th>
                                                        <th>Tahun</th>
                                                        <th>Status</th>
                                                        <!-- <th>Catatan</th> -->
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($query as $data)
                                                        @php
                                                            $id = Crypt::encryptString(
                                                                $data->bulan . ',' . $data->badan_usaha_id,
                                                            );
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <b><a
                                                                        href="{{ url('/laporan/pasokan/gb') }}/{{ $id }}">{{ getBulan($data->bulan) }}
                                                                        <i class="bx bx-check"
                                                                            title="lihat data laporan"></i></a><b>
                                                            </td>
                                                            <td>
                                                                <b><a
                                                                        href="{{ url('/laporan/pasokan/gb') }}/{{ $id }}/tahun">{{ getTahun($data->bulan) }}
                                                                        <i class="bx bx-check"
                                                                            title="lihat data laporan"></i></a><b>
                                                            </td>
                                                            <td>
                                                                @if ($data->status == 1 && $data->catatan)
                                                                    <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                                @elseif ($data->status == 1)
                                                                    <span class="badge bg-success">Kirim</span>
                                                                @elseif ($data->status == 2)
                                                                    <span class="badge bg-danger">Revisi</span>
                                                                @elseif ($data->status == 0)
                                                                    <span class="badge bg-info">draf</span>
                                                                @elseif($data->status == 3)
                                                                    <span class="badge bg-primary">Selesai</span>
                                                                @endif
                                                            </td>

                                                            @if ($data->status == 1)
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-info btn-sm rounded-pill btn-update"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-update" title="Revisi data">
                                                                        <i class="bx bxs-edit align-middle"></i>
                                                                    </button>

                                                                    @if ($data->status == 1 && $data->catatan)
                                                                        <button
                                                                            class="btn btn-primary btn-rounded btn-sm btn-selesai-status"
                                                                            data-p="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->badan_usaha_id) }}"
                                                                            data-b="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->bulan) }}"><i
                                                                                class="bx bx-check"
                                                                                title="Selesai"></i></button>
                                                                    @endif

                                                                    <div class="modal fade" id="modal-update"
                                                                        data-bs-backdrop="static" data-bs-keyboard="false"
                                                                        aria-labelledby="staticBackdropLabel"
                                                                        aria-hidden="true">
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
                                                                                    action="{{ url('/laporan/pasokan/gb/update-revision-all') }}"
                                                                                    method="post" id="updateStatusForm"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <input type="hidden" name="p"
                                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->badan_usaha_id) }}">
                                                                                    <input type="hidden" name="b"
                                                                                        value="{{ \Illuminate\Support\Facades\Crypt::encrypt($data->bulan) }}">
                                                                                    <div class="modal-body">
                                                                                        <label
                                                                                            for="catatan">Notesss</label>
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

                                                                </td>
                                                            @else
                                                                <td>

                                                                </td>
                                                            @endif
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
            @endif
        </div>
    </div> --}}

@endsection

@section('script')
    <script>
        // Add an event listener to the button
        // Menggunakan querySelectorAll untuk mendapatkan semua elemen dengan kelas '.btn-selesai'
        document.querySelectorAll('.btn-selesai-status').forEach(function(button) {
            // Menambahkan event listener ke setiap elemen button
            button.addEventListener('click', function() {
                // Mengambil nilai id dari atribut data-id
                var p = this.getAttribute('data-p');
                var b = this.getAttribute('data-b');

                console.log('cek p =', p);
                console.log('cek d =', b);

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
                            url: '{{ url('/laporan/pasokan/gb/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                p: p,
                                b: b,
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
