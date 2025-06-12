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
                    <li class="breadcrumb-item text-muted">Niaga BBM</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/laporan/penjualan-jbkp') }}" class="text-muted text-hover-primary">Penjualan JBT</a>
                    </li>
                    <li class="breadcrumb-item">
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        @if ($query)
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">{{ $per->nama_badan_usaha }}</h4>
                                
                                <a href="{{ url('/laporan/penjualan-jbt') }}" class="btn btn-danger btn-sm btn-rounded">
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
                                <input type="hidden" class="export-title" value="Laporan Penjualan JBT {{ $per->nama_badan_usaha }}" />
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Bulan</th>
                                    <th class="text-center">Tahun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
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

                                        <td class="text-center">
                                            <a href="{{ url('/laporan/penjualan-jbt') }}/{{ $params }}"
                                                class="btn btn-sm btn-primary btn-rounded">
                                                <i class="bi bi-eye fs-3"></i> Lihat Detail
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
        @endif
    </div>
</div>

{{-- Index lama --}}
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


            <!-- tes -->
            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ $per->nama_badan_usaha }}</h4>
                                    <div>
                                        <a href="{{ url('/laporan/penjualan-jbt') }}"
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
                                                                <a href="{{ url('/laporan/penjualan-jbt') }}/{{ $params }}"
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
