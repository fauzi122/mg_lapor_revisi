@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{$title}}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">{{$title}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                            <h4>{{$per->NAMA_PERUSAHAAN}}</h4>

                        </div>

                    </div>
                </div>
            </div>

            @if($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode Bulan {{ dateIndonesia($per->bulan)}}</h4>

                                    <div>
                                        <a href="{{url('laporan/pasokan/mb/periode').'/'.\Illuminate\Support\Facades\Crypt::encrypt($per->badan_usaha_id)}}"
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
                                                    <form action="{{ url('/laporan/pasokan/mb/update-revision-all') }}"
                                                          method="post" id="updateStatusForm"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="p"
                                                               value="{{\Illuminate\Support\Facades\Crypt::encrypt($per->badan_usaha_id)}}">
                                                        <input type="hidden" name="b"
                                                               value="{{\Illuminate\Support\Facades\Crypt::encrypt($per->bulan)}}">
                                                        <div class="modal-body">
                                                            <label for="catatan">Notes</label>
                                                            <textarea name="catatan" id="catatan" cols="5" rows="5"
                                                                      class="form-control"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary"
                                                            >Update
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
                                    <table id="datatable-buttons"
                                           class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Kategori Pemasok</th>
                                            <th>Intake Kilang</th>
                                            <th>Produk</th>
                                            <th>Aksi</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Keterangan</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($query as $pgb)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ dateIndonesia($pgb->bulan) }}</td>
                                                <td>
                                                    @if ($pgb->status == 1 && $pgb->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($pgb->status == 1)
                                                        <span class="badge bg-success">Kirim</span>
                                                    @elseif ($pgb->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @elseif ($pgb->status == 3)
                                                        <span class="badge bg-primary">Selesai</span>
                                                    @elseif ($pgb->status == 0)
                                                        <span class="badge bg-info">draf</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pgb->catatan }}</td>

                                                <td>{{ $pgb->kategori_pemasok }}</td>
                                                <td>{{ $pgb->intake_kilang }}</td>
                                                <td>{{ $pgb->produk }}</td>


                                                <td>
                                                    @if ($pgb->status == 1 )
                                                        <button type="button"
                                                                class="btn btn-info btn-sm rounded-pill btn-update"
                                                                data-bs-toggle="modal" data-bs-target="#modal-update"
                                                                title="Revisi data">
                                                            <i class="bx bxs-edit align-middle"></i>
                                                        </button>
                                                        <button class="btn btn-primary btn-rounded btn-sm btn-selesai"
                                                                data-id="{{$pgb->id}}"><i
                                                                    class="bx bx-check"
                                                                    title="Selesai"></i></button>

                                                        <div class="modal fade" id="modal-update"
                                                             data-bs-backdrop="static"
                                                             data-bs-keyboard="false"
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
                                                                    <form action="{{ url('/laporan/produksi/mb/update-revision') }}"
                                                                          method="post" id="updateStatusForm"
                                                                          enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                               value="{{\Illuminate\Support\Facades\Crypt::encrypt($pgb->id)}}">
                                                                        <div class="modal-body">
                                                                            <label for="catatan">Notes</label>
                                                                            <textarea name="catatan" id="catatan"
                                                                                      cols="5" rows="5"
                                                                                      class="form-control"></textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close
                                                                            </button>
                                                                            <button type="submit"
                                                                                    class="btn btn-primary"
                                                                            >Update
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif


                                                </td>


                                                <td>{{ $pgb->provinsi }}</td>
                                                <td>{{ $pgb->kabupaten_kota }}</td>
                                                <td>{{ $pgb->sektor }}</td>
                                                <td>{{ $pgb->volume }}</td>
                                                <td>{{ $pgb->satuan }}</td>
                                                <td>{{ $pgb->keterangan }}</td>


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

            @endif
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $('.btn-selesai-status').on('click', function () {
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
                            url: '{{ url('/laporan/pasokan/mb/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                b: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->bulan) }}',
                                p: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->badan_usaha_id) }}'
                            },
                            success: function (response) {
                                Swal.fire('Status diperbarui!', 'Periode telah diselesaikan.', 'success')
                                    .then(function () {
                                        location.reload();
                                    });
                            },
                            error: function (error) {
                                Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui status.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>


    <script>

        document.querySelectorAll('.btn-selesai').forEach(function (button) {
            // Menambahkan event listener ke setiap elemen button
            button.addEventListener('click', function () {
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
                            url: '{{ url('/laporan/pasokan/mb/selesai-periode') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id, // Menggunakan nilai id yang diambil dari atribut data-id
                            },
                            success: function (response) {
                                // Handle the response from the server
                                // For example, show a success message
                                Swal.fire('Status diperbarui!', 'Periode telah diselesaikan.', 'success')
                                    .then(function () {
                                        // Reload the page after the SweetAlert is closed
                                        location.reload();
                                    });
                            },
                            error: function (error) {
                                // Handle errors, show an error message, etc.
                                Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui status.', 'error');
                            }
                        });
                    }
                });
            });
        });

    </script>

@endsection