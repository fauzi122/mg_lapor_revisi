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

                                <button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-bs-toggle="modal"
                                                    data-bs-target=".bs-example-modal-lg"><i class="bx bx-import"></i>Import Excel</button>
                                            
                                                <!--  Large modal example -->
                                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="myLargeModalLabel">Import Excel Data LPG Subsidi Verified</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="/lpg/storeSubsidi_excel" method="post" id="myform" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="bulan">Bulan*</label>
                                                                        <input class="form-control mb-2" type="month" id="bulan" name="bulan" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="file">File *</label>
                                                                        <input class="form-control mb-2" type="file" id="file" name="file" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
                                                                    <a href="/storage/template/Subsidi_LPG.xlsx" type="button" class="btn btn-success btn-rounded">Download Templet Excel</a>
                                                                </div>
                                                            </form>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal -->                                                


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
                                                @include('evaluator.subsidi_lpg.lpg_subsidi.modalstor')

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
                                                <th>Volume</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($lpg_subsidi as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getBulan($data->bulan) }}</td> 
                                                    <td>{{ getTahun($data->bulan) }}</td>
                                                   
                                                    <td>{{ $data->provinsi }}</td>
                                                    <td>{{ $data->volume }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning btn-rounded edit-button"
                                                        data-id="{{ $data->id }}"
                                                        data-bulan="{{ $data->bulan }}"
                                                        data-provinsi="{{ $data->provinsi }}"
                                                        data-volume="{{ $data->volume }}"
                                                        data-bs-toggle="modal" data-bs-target="#editKuotaModal">
                                                    <i class="bx bx-edit"></i> Edit
                                                </button>
                                                 
                                                <!-- Modal Edit Kuota -->
                                                <div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog" aria-labelledby="editKuotaModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="/lpg/subsidi/update/{{ $data->id }}" method="post" id="editKuotaForm">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editKuotaModalLabel">Edit Data LPG Subsidi </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="editBulan">Bulan*</label>
                                                                        <input class="form-control mb-2" type="month" id="editBulan" name="bulan" value="{{ substr($data->bulan, 0, 7) }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editProvinsi">Provinsi*</label>
                                                                        <select name="provinsi" id="editProvinsi" class="form-control" required>
                                                                            <option value="">--Pilih Provinsi--</option>
                                                                            @foreach ($provinsi as $prov)
                                                                                <option value="{{ $prov['name'] }}" {{ ($data->provinsi == $prov['name']) ? 'selected' : '' }}>{{ $prov['name'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editVolume">Volume*</label>
                                                                        <input class="form-control" type="number" min="0" id="editVolume" name="volume" value="{{ $data->volume }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                

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
                        url: '/lpg/subsidi/delete/' + itemId,
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
<script>
    $(document).ready(function () {
    // Ketika tombol edit ditekan
    $('.edit-button').on('click', function () {
        var kuotaId = $(this).data('id');
        var bulan = $(this).data('bulan');  // Ambil data bulan (tahun)
        var provinsi = $(this).data('provinsi');  // Ambil data provinsi
       
        var volume = $(this).data('volume');  // Ambil data volume

        // Isi form edit di modal
        $('#editBulan').val(bulan);
        $('#editProvinsi').val(provinsi);
        $('#editVolume').val(volume);

       

        // Set form action URL sesuai dengan kuota ID
        // $('#editKuotaForm').attr('action', '/lpg/kuota/updateaaa/' + kuotaId);

        // Tampilkan modal edit
        $('#editKuotaModal').modal('show');
    });
});
</script>



@endsection

