@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
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


            {{-- tes --}}
            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ $per->nama_badan_usaha }}</h4>
                                    <div>
                                        <a href="{{ url('/laporan/penjualan-jbkp') }}"
                                            class="btn btn-danger btn-sm btn-rounded">
                                            <i class='bx bx-arrow-back'></i> Kembali
                                        </a>

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
                                                        <th>No</th>
                                                        <th>Bulan</th>
                                                        <th>Tahun</th>

                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($query as $i => $row)
                                                        @php
                                                            $params = Crypt::encryptString(
                                                                $row->npwp_badan_usaha .
                                                                    ',' .
                                                                    $row->tahun .
                                                                    ',' .
                                                                    $row->bulan,
                                                            );
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>
                                                                <a class="text-primary">
                                                                    {{ \Carbon\Carbon::createFromFormat('m', $row->bulan)->translatedFormat('F') }}
                                                                </a>
                                                            </td>
                                                            <td><span class="text-primary">{{ $row->tahun }}</span></td>

                                                            <td>
                                                                <a href="{{ url('/laporan/penjualan-jbkp') }}/{{ $params }}"
                                                                    class="btn btn-sm btn-primary btn-rounded">
                                                                    <i class="bx bx-show"></i> Lihat Detail
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
                            url: '{{ url('/laporan/pengangkutan/mb/selesai-periode-all') }}',
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
