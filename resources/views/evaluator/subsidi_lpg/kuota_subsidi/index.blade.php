@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
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
                                                <form action="/lpg/kuota/store" method="post" id="myform"
                                                      enctype="multipart/form-data">

                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="bulan">Bulan*</label>
                                                        <select class="form-control select20 select2-hidden-accessible mb-2"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                name="bulan">
                                                            <option value="">--Pilih Bulan--</option>
                                                            @php
                                                                $currentMonth = now();
                                                                $months = [];
                                                                for ($i = 0; $i < 15; $i++) {
                                                                $formattedMonth = $currentMonth->format('Y-m-01');
                                                                $months[$formattedMonth] = dateIndonesia($currentMonth->format('Y-m-01'));
                                                                $currentMonth->subMonth();
                                                                }
                                                            @endphp

                                                            @foreach ($months as $value => $label)
                                                                <option value="{{ $value }}">{{ $label }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="provinsi">Provinsi*</label>
                                                        <select name="provinsi" id="provinsiTambah"
                                                                class="form-control select20 select2-hidden-accessible mb-2"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                            <option value="">--Pilih Provinsi--</option>
                                                            @foreach ($provinsi as $prov)
                                                                <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="kabkot">Kabupaten/Kota*</label>
                                                        <select name="kabkot" id="kabkotTambah"
                                                                class="form-control select20 select2-hidden-accessible mb-2"
                                                                style="width: 100%; display: none" tabindex="-1" aria-hidden="true" >
                                                            <option value="">--Pilih Kabupaten--</option>

                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="volume">Volume*</label>
                                                        <input class="form-control mb-2" type="number" min=0 id="volume"
                                                               name="volume" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-primary btn-rounded"> Simpan</button>
                                                    </div>
                                                </form>

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
                                                    <td>{{ dateIndonesia($data->tahun  ) }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->NAMA_KABKOT }}</td>
                                                    <td>{{ $data->volume }}</td>
                                                    <td>
                                                        <a href="" class="btn btn-warning btn-sm btn-rounded edit-btn" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id }}">
                                                            <i class="bx bx-edit"></i> Edit
                                                        </a>
                                                        <div class=" modal fade modal-select bs-example-modal-xl" id="editModal{{$data->id}}" tabindex="-1" role="dialog"
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
                                                                        <form action="/lpg/kuota/update" method="post" id="myform"
                                                                              enctype="multipart/form-data">

                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{$data->id}}">
                                                                            <div class="mb-3">
                                                                                <label for="bulan">Bulan*</label> <br>
                                                                                <select class="form-control select20 select2-hidden-accessible mb-2"
                                                                                        style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                                        name="bulan">
                                                                                    <option value="{{$data->tahun}}">{{dateIndonesia($data->tahun)}}</option>
                                                                                    <option value="">--Pilih Bulan--</option>
                                                                                    @php
                                                                                        $currentMonth = now();
                                                                                        $months = [];
                                                                                        for ($i = 0; $i < 15; $i++) {
                                                                                        $formattedMonth = $currentMonth->format('Y-m-01');
                                                                                        $months[$formattedMonth] = dateIndonesia($currentMonth->format('Y-m-01'));
                                                                                        $currentMonth->subMonth();
                                                                                        }
                                                                                    @endphp

                                                                                    @foreach ($months as $value => $label)
                                                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="provinsi">Provinsi*</label> <br>
                                                                                <select name="provinsi" id="provinsiEdit"
                                                                                        class="form-control select20 select2-hidden-accessible mb-2"
                                                                                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                                                    <option value="{{$data->provinsi}}">{{$data->name}}</option>
                                                                                    <option value="">--Pilih Provinsi--</option>
                                                                                    @foreach ($provinsi as $prov)
                                                                                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="kabkot">Kabupaten/Kota*</label><br>
                                                                                <select name="kabkot" id="kabkotEdit"
                                                                                        class="form-control select20 select2-hidden-accessible mb-2"
                                                                                        style="width: 100%; display: none" tabindex="-1" aria-hidden="true" >
                                                                                    <option value="{{$data->kabupaten_kota}}">{{$data->NAMA_KABKOT}}</option>

                                                                                </select>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label for="volume">Volume*</label>
                                                                                <input class="form-control mb-2" type="number" id="volume"
                                                                                       name="volume" min=0 value="{{$data->volume}}" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <button type="submit" class="btn btn-warning btn-rounded"> Update</button>
                                                                            </div>
                                                                        </form>

                                                                    </div>

                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->
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
    </div>




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

    <!-- Pastikan jQuery sudah di-include sebelum script ini -->

    <script>
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
    </script>


@endsection

