@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data Kuota LPG Subsidi Verified</h3>
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
                    <li class="breadcrumb-item text-muted">Data Kuota LPG Subsidi Verified</li>
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
                                data-bs-toggle="modal" data-bs-target="#kt_modal_new_target"><i class="bi bi-file-earmark-plus fs-4"></i>Tambah Data
                                </button>

                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_new_excel"><i class="bi bi-upload fs-4"></i></i> Import Excel</button>
                            
                                <!--  Import Excel Modal dan Tambah Data Modal  -->

                                @include('evaluator.subsidi_lpg.kuota_subsidi.modal_import')

                                @include('evaluator.subsidi_lpg.kuota_subsidi.modalstor')

                                <!-- End Import Excel Modal dan Tambah Data Modal-->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-2">
                    <div class="card">
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Data Kuota LPG Subsidi" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Volume</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($lpg_subsidi as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ getBulan($data->tahun) }}</td> 
                                        <td>{{ getTahun($data->tahun) }}</td>
                                        <td>{{ $data->provinsi }}</td>
                                        <td>{{ $data->kabupaten_kota }}</td>
                                        <td>{{ $data->volume }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning btn-rounded edit-button"
                                                data-id="{{ $data->id }}"
                                                data-bulan="{{ substr($data->tahun, 0, 7) }}"
                                                data-provinsi="{{ $data->provinsi }}"
                                                data-kabkot="{{ $data->kabupaten_kota }}"
                                                data-volume="{{ $data->volume }}"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_edit">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            
                                            @include('evaluator.subsidi_lpg.kuota_subsidi.modaledit')
                        
                                            <a href="#" class="btn btn-danger btn-sm btn-rounded delete-btn"
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


    {{-- <div class="page-content">
        <div class="container-fluid">
            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Data LPG Subsidi Verified</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">Data LPG Subsidi Verified</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Success message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Data table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-primary  btn-rounded waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i class="bx bx-plus"></i> Tambah Data
                                </button>
                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target=".bs-example-modal-lg"><i class="bx bx-import"></i>Import Excel</button>
                                
                                @include('evaluator.subsidi_lpg.kuota_subsidi.modal_import')

                                <div class=" modal fade modal-select bs-example-modal-xl" tabindex="-1" role="dialog"
                                     aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myExtraLargeModalLabel">Data LPG Subsidi Verified</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form yang diambil dari form sebelumnya -->
                                                @include('evaluator.subsidi_lpg.kuota_subsidi.modalstor')
                                              

                                            </div>

                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="penjualan">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons"
                                               class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Provinsi</th>
                                                <th>Kabupaten/Kota</th>
                                                <th>Volume</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($lpg_subsidi as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    
                                                    <td>{{ getBulan($data->tahun) }}</td> 
                                                    <td>{{ getTahun($data->tahun) }}</td>
                                                    <td>{{ $data->provinsi }}</td>
                                                    <td>{{ $data->kabupaten_kota }}</td>
                                                    <td>{{ $data->volume }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning btn-sm btn-rounded edit-button"
                                                            data-id="{{ $data->id }}"
                                                            data-bulan="{{ substr($data->tahun, 0, 7) }}"
                                                            data-provinsi="{{ $data->provinsi }}"
                                                            data-kabkot="{{ $data->kabupaten_kota }}"
                                                            data-volume="{{ $data->volume }}">
                                                            <i class="bx bx-edit"></i> Edit
                                                    </button>
                                                    @include('evaluator.subsidi_lpg.kuota_subsidi.modaledit')
                                                        <a href="" class="btn btn-warning btn-sm btn-rounded edit-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id }}">
                                                            <i class="bx bx-edit"></i> Edit
                                                        </a>

                                                        <a href="#" class="btn btn-danger btn-sm btn-rounded delete-btn"
                                                           data-id="{{ $data->id }}" onclick="deleteItem({{ $data->id }})">
                                                            <i class='bx bx-trash'></i> Hapus
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
            </div>
        </div>
    </div> --}}




@endsection
@section('script')
    <script>
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
                        url: '/lpg/kuota/delete/' + itemId,
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (data) {
                            Swal.fire({
                                title: 'Dihapus!',
                                text: 'Item telah dihapus.',
                                icon: 'success',
                                timer: 2000, // Set waktu (dalam milidetik) sebelum SweetAlert ditutup otomatis
                                showConfirmButton: false // Atur menjadi false untuk menghilangkan tombol "OK"
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus item.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
<script>
    $(document).ready(function () {
        // When the province is selected
        $('#provinsiTambah').on('change', function () {
            var selectedProvince = $(this).val();

            if (selectedProvince !== '') {
                $.ajax({
                    url: '/get-kabkot/' + selectedProvince, // Fetch kabkot data based on province
                    type: 'GET',
                    success: function (data) {
                        var kabkotSelect = $('#kabkotTambah');
                        kabkotSelect.empty().append('<option value="">--Pilih Kabupaten--</option>');
                        $.each(data, function (index, kabkot) {
                            kabkotSelect.append('<option value="' + kabkot.NAMA_KABKOT + '">' + kabkot.NAMA_KABKOT + '</option>');
                        });
                        kabkotSelect.show();
                    },
                    error: function () {
                        alert('Error retrieving Kabupaten/Kota.');
                    }
                });
            } else {
                $('#kabkotTambah').hide();
            }
        });
    });
</script>
<script>
$(document).ready(function () {
    // Ketika tombol edit ditekan
    $('.edit-button').on('click', function () {
        var kuotaId = $(this).data('id');
        var bulan = $(this).data('bulan');  // Ambil data bulan (tahun)
        var provinsi = $(this).data('provinsi');  // Ambil data provinsi
        var kabkotSelected = $(this).data('kabkot');  // Ambil data kabupaten/kota yang tersimpan sebelumnya
        var volume = $(this).data('volume');  // Ambil data volume

        // Isi form edit di modal
        $('#editBulan').val(bulan);
        $('#editProvinsi').val(provinsi);
        $('#editVolume').val(volume);

        // Fetch kabupaten/kota berdasarkan provinsi
        $.ajax({
            url: '/get-kabkot/' + provinsi,  // Pastikan endpoint ini benar
            type: 'GET',
            success: function (data) {
                var kabkotSelect = $('#editKabkot');
                kabkotSelect.empty().append('<option value="">--Pilih Kabupaten--</option>'); // Kosongkan dropdown dan tambahkan placeholder
                $.each(data, function (index, kabkot) {
                    // Tambahkan setiap kabupaten/kota ke dropdown, dan set sebagai selected jika sama dengan kabkot yang sudah tersimpan
                    kabkotSelect.append('<option value="' + kabkot.NAMA_KABKOT + '" ' + (kabkot.NAMA_KABKOT == kabkotSelected ? 'selected' : '') + '>' + kabkot.NAMA_KABKOT + '</option>');
                });
                kabkotSelect.show();
            },
            error: function () {
                alert('Error retrieving Kabupaten/Kota.');
            }
        });

        // Set form action URL sesuai dengan kuota ID
        $('#editKuotaForm').attr('action', '/lpg/kuota/update/' + kuotaId);

        // Tampilkan modal edit
        $('#editKuotaModal').modal('show');
    });
});


</script>

    <!-- Pastikan jQuery sudah di-include sebelum script ini -->

    {{-- <script>
        $(document).ready(function () {
            // Fungsi untuk menangani perubahan pada elemen provinsi dan kabkot
            function handleProvinsiChange(provinsiSelect, kabkotSelect, defaultKabkot) {
                var selectedProvinsi = provinsiSelect.val();

                if (selectedProvinsi !== '') {
                    $.ajax({
                        url: '/lpg/kuota/kabkot/' + selectedProvinsi,
                        type: 'GET',
                        success: function (data) {
                            kabkotSelect.empty(); // Clear existing options
                            kabkotSelect.append('<option value="">--Pilih Kabupaten--</option>');

                            // Add new options
                            $.each(data, function (index, kabkot) {
                                var option = '<option value="' + kabkot.ID_KABKOT + '">' + kabkot.NAMA_KABKOT + '</option>';
                                kabkotSelect.append(option);
                            });

                            // Set default value based on the provided parameter
                            kabkotSelect.val(defaultKabkot);

                            kabkotSelect.show(); // Display the select element
                        },
                        error: function (error) {
                            console.error('Error fetching kabkot data:', error);
                        }
                    });
                } else {
                    kabkotSelect.hide(); // Hide the select element if provinsi is not selected
                }
            }

            // Menggunakan fungsi untuk menangani elemen pada halaman

            // Operasi Tambah
            var provinsiSelectTambah = $('#provinsiTambah');
            var kabkotSelectTambah = $('#kabkotTambah');

            // Menangani perubahan pada elemen provinsi
            provinsiSelectTambah.change(function () {
                handleProvinsiChange(provinsiSelectTambah, kabkotSelectTambah, "");
            });

            // Trigger change event to initialize kabkot options on modal show
            // Gantilah 'myModalTambah' dengan id modal tambah yang sesuai
            $('#myModalTambah').on('shown.bs.modal', function () {
                provinsiSelectTambah.trigger('change');
            });

            // Operasi Edit
            var provinsiSelectEdit = $('#provinsiEdit');
            var kabkotSelectEdit = $('#kabkotEdit');

            // Menangani perubahan pada elemen provinsi
            provinsiSelectEdit.change(function () {
                handleProvinsiChange(provinsiSelectEdit, kabkotSelectEdit, "{{$data->kabupaten_kota}}");
            });

            // Trigger change event to initialize kabkot options on modal show
            // Gantilah 'editModal{{$data->id}}' dengan id modal edit yang sesuai
            $('#editModal{{$data->id}}').on('shown.bs.modal', function () {
                provinsiSelectEdit.trigger('change');
            });
        });
    </script> --}}


@endsection

