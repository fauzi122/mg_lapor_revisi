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

            @if ($query)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-0"
                                    role="alert">
                                    <i class="mdi mdi-alert-circle-outline label-icon"></i>
                                    <strong>Informasi:</strong> Data yang ditampilkan di halaman ini adalah data untuk bulan
                                    berjalan.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Periode {{ $periode }}</h4>
                                    <div>
                                        <a href="{{ url('laporan/penyimpanan/mb') }}"
                                            class="btn btn-danger waves-effect waves-light">
                                            <i class='bx bx-arrow-back'></i> Kembali
                                        </a>
                                        <button type="button" class="btn btn-primary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">
                                            <i class='bx bx-filter-alt'></i> Filter
                                        </button>


                                        {{-- Modal cetak --}}
                                        <div class="modal fade modal-select bs-example-modal-center" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Filter</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('laporan/penyimpanan/mb-lihat-semua-data') }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Nama
                                                                    Perusahaan</label>
                                                                <select
                                                                    class="form-control select20 select2-hidden-accessible mb-2"
                                                                    style="width: 100%;" name="perusahaan" required>
                                                                    <option value="all" selected>--Pilih Perusahaan--
                                                                    </option>
                                                                    <option value="all">Semua Perusahaan</option>
                                                                    @foreach ($perusahaan as $p)
                                                                        <option value="{{ $p->id_perusahaan }}">
                                                                            {{ $p->NAMA_PERUSAHAAN }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Awal</label>
                                                                <input class="form-control" name="t_awal" type="date"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="example-text-input" class="form-label">Tanggal
                                                                    Akhir</label>
                                                                <input class="form-control" name="t_akhir" type="date"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <button type="submit" data-bs-dismiss="modal"
                                                                    class="btn btn-primary">Proses</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatable-buttons"
                                        class="table table-bordered table-striped dt nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                                <th>Status</th>
                                                <th>Catatan</th>
                                                <th>No Tangki</th>
                                                <th>Produk</th>
                                                <th>Kab/Kota</th>
                                                <th>Jenis Komoditas</th>
                                                <th>Kapasitas Tangki</th>
                                                <th>Volume Awal</th>
                                                <th>Volume Supply</th>
                                                <th>Volume Output</th>
                                                <th>Volume Stok Akhir</th>
                                                <th>Satuan</th>
                                                <th>Utilisasi Tangki</th>
                                                <th>Aksi</th>
                                                <th>Pengguna</th>
                                                <th>Tarif Penyimpanan</th>
                                                <th>Satuan Tarif</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Awal</th>
                                                <th>Tanggal Akhir</th>
                                                <th>Commingle</th>
                                                <th>Jumlah BU</th>
                                                <th>Nama Penyewa</th>
                                                <th>Kapasitas Penyewaan</th>
                                                <th>Kontrak Sewa</th>
                                                <th>Tanggal Dibuat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $pgb)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pgb->NAMA_PERUSAHAAN }}</td>
                                                    <td>{{ getBulan($pgb->bulan) }}</td>
                                                    <td>{{ getTahun($pgb->bulan) }}</td>
                                                    <td>
                                                        @if ($pgb->status == 1 && $pgb->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pgb->status == 1)
                                                            <span class="badge bg-success">Diterima</span>
                                                        @elseif ($pgb->status == 2)
                                                            <span class="badge bg-danger">Revisi</span>
                                                        @elseif ($pgb->status == 3)
                                                            <span class="badge bg-primary">Selesai</span>
                                                        @elseif ($pgb->status == 0)
                                                            <span class="badge bg-info">Draf</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $pgb->catatan }}</td>
                                                    <td>{{ $pgb->no_tangki }}</td>
                                                    <td>{{ $pgb->produk }}</td>
                                                    <td>{{ $pgb->kab_kota }}</td>
                                                    <td>{{ is_array(json_decode($pgb->jenis_komoditas, true)) ? implode(', ', json_decode($pgb->jenis_komoditas, true)) : $pgb->jenis_komoditas }}
                                                    </td>
                                                    <td>{{ $pgb->kapasitas_tangki }}</td>
                                                    <td>{{ $pgb->volume_stok_awal }}</td>
                                                    <td>{{ $pgb->volume_supply }}</td>
                                                    <td>{{ $pgb->volume_output }}</td>
                                                    <td>{{ $pgb->volume_stok_akhir }}</td>
                                                    <td>{{ $pgb->satuan }}</td>
                                                    <td>{{ $pgb->utilisasi_tangki }}</td>
                                                    <td>
                                                        @if ($pgb->status == 1)
                                                            <button type="button"
                                                                class="btn btn-info btn-sm rounded-pill btn-update"
                                                                data-bs-toggle="modal" data-bs-target="#modal-update"
                                                                title="Revisi data">
                                                                <i class="bx bxs-edit align-middle"></i>
                                                            </button>

                                                            @if ($pgb->status == 1 && $pgb->catatan)
                                                                <button
                                                                    class="btn btn-primary btn-rounded btn-sm btn-selesai"
                                                                    data-id="{{ $pgb->id }}">
                                                                    <i class="bx bx-check" title="Selesai"></i>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{ $pgb->pengguna }}</td>
                                                    <td>{{ $pgb->tarif_penyimpanan }}</td>
                                                    <td>{{ $pgb->satuan_tarif }}</td>
                                                    <td>{{ $pgb->keterangan }}</td>
                                                    <td>{{ $pgb->tanggal_awal }}</td>
                                                    <td>{{ $pgb->tanggal_akhir }}</td>
                                                    <td>{{ $pgb->commingle }}</td>
                                                    <td>{{ $pgb->jumlah_bu }}</td>
                                                    <td>{{ $pgb->nama_penyewa }}</td>
                                                    <td>{{ $pgb->kapasitas_penyewaan }}</td>
                                                    <td>{{ $pgb->kontrak_sewa }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($pgb->created_at)->format('d F Y') }}</td>
                                                </tr>
                                            @endforeach
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

{{-- @section('script')
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
                            url: '{{ url('/laporan/jual-hasil-olahan/selesai-periode-all') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                b: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->bulan) }}',
                                p: '{{ \Illuminate\Support\Facades\Crypt::encrypt($per->badan_usaha_id) }}'
                            },
                            success: function(response) {
                                Swal.fire('Status diperbarui!', 'Periode telah diselesaikan.', 'success').then(function() {
                                    location.reload();
                                });
                            },
                            error: function(error) {
                                Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui status.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        document.querySelectorAll('.btn-selesai').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                console.log('cek id =', id);

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
                            url: '{{ url('/laporan/jual-hasil-olahan/selesai-periode') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(response) {
                                Swal.fire('Status diperbarui!', 'Periode telah diselesaikan.', 'success').then(function() {
                                    location.reload();
                                });
                            },
                            error: function(error) {
                                Swal.fire('Gagal', 'Terjadi kesalahan saat memperbarui status.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection --}}