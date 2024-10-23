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



            @if($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                <h4>{{$per->NAMA_PERUSAHAAN}}</h4>
                                <div>
                                    <a href="{{url('laporan/harga-lpg')}}" class="btn btn-danger btn-sm btn-rounded"><i class='bx bx-arrow-back'></i> Kembali</a>
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
                                                        $id = Crypt::encryptString($data->bulan . ',' . $data->badan_usaha_id);
                                                        $idTahun = Crypt::encryptString($data->bulan . ',' . $data->badan_usaha_id . ', tahun');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <b><a href="/laporan/harga-lpg/{{ $id }}">{{ getBulan($data->bulan) }}
                                                                    <i
                                                                            {{-- class="bx bx-check" --}}
                                                                            title="lihat data laporan"></i></a><b>
                                                        </td>
                                                        <td>
                                                            <b><a href="/laporan/harga-lpg/{{ $idTahun }}">{{ getTahun($data->bulan) }}
                                                                    <i
                                                                            {{-- class="bx bx-check" --}}
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
                                                            @elseif($data->status ==3)
                                                                <span class="badge bg-primary">Selesai</span>
                                                            @endif
                                                        </td>

                                                        @if ($data->status == 1)
                                                            <td>
                                                                <button type="button" class="btn btn-info btn-sm rounded-pill btn-update"
                                                                        data-bs-toggle="modal" data-bs-target="#modal-update" title="Revisi data">
                                                                    <i class="bx bxs-edit align-middle"></i>
                                                                </button>

                                                                <button class="btn btn-primary btn-rounded btn-sm btn-selesai-status" data-p="{{\Illuminate\Support\Facades\Crypt::encrypt($data->badan_usaha_id)}}" data-b="{{\Illuminate\Support\Facades\Crypt::encrypt($data->bulan)}}"><i
                                                                            class="bx bx-check"
                                                                            title="Selesai"></i></button>

                                                                <div class="modal fade" id="modal-update" data-bs-backdrop="static"
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
                                                                            <form action="{{ url('/laporan/harga-lpg/update-revision-all') }}"
                                                                                  method="post" id="updateStatusForm"
                                                                                  enctype="multipart/form-data">
                                                                                @csrf
                                                                                <input type="hidden" name="p"
                                                                                       value="{{\Illuminate\Support\Facades\Crypt::encrypt($data->badan_usaha_id)}}">
                                                                                <input type="hidden" name="b"
                                                                                       value="{{\Illuminate\Support\Facades\Crypt::encrypt($data->bulan)}}">
                                                                                <div class="modal-body">
                                                                                    <label for="catatan">Notesss</label>
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
    </div>

@endsection

@section('script')

    <script>
        // Add an event listener to the button
        // Menggunakan querySelectorAll untuk mendapatkan semua elemen dengan kelas '.btn-selesai'
        document.querySelectorAll('.btn-selesai-status').forEach(function(button) {
            // Menambahkan event listener ke setiap elemen button
            button.addEventListener('click', function () {
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
                            url: '{{ url('/laporan/harga-lpg/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                p: p,
                                b: b,
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