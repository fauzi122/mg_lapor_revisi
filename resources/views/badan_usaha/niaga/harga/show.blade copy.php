@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Harga</h4>
                    </div>
                </div>
            </div>
            {{-- Harga BBM JBU/Hasil Olahan/Minyak Bumi --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Harga BBM JBU/Hasil Olahan/Minyak Bumi
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" onclick="produk(); provinsi();"
                                        data-bs-target="#input_HargaBBM">Buat Laporan
                                    </button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelhbjbu">Import Excel
                                    </button>
                                    @include('badan_usaha.niaga.harga.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table3" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Volume</th>
                                            <th>Biaya Perolehan</th>
                                            <th>Biaya Distribusi</th>
                                            <th>Biaya Penyimpanan</th>
                                            <th>Margin</th>
                                            <th>PPN</th>
                                            <th>PBBKP</th>
                                            <th>Harga Jual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hargabbmjbu as $hargabbmjbu)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $hargabbmjbu->bulan }}</td>
                                                <td>{{ $hargabbmjbu->produk }}</td>
                                                <td>{{ $hargabbmjbu->provinsi }}</td>
                                                <td>{{ $hargabbmjbu->volume }}</td>
                                                <td>{{ $hargabbmjbu->biaya_perolehan }}</td>
                                                <td>{{ $hargabbmjbu->biaya_distribusi }}</td>
                                                <td>{{ $hargabbmjbu->biaya_penyimpanan }}</td>
                                                <td>{{ $hargabbmjbu->margin }}</td>
                                                <td>{{ $hargabbmjbu->ppn }}</td>
                                                <td>{{ $hargabbmjbu->pbbkp }}</td>
                                                <td>{{ $hargabbmjbu->harga_jual }}</td>
                                                <td>
                                                    @if ($hargabbmjbu->status == '0' || $hargabbmjbu->status == '-' || $hargabbmjbu->status == '')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editHarga"
                                                                onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                id="editharga" data-bs-toggle="modal"
                                                                data-bs-target="#edit-hargabbm"
                                                                data-id="{{ $hargabbmjbu->id }}">
                                                                <i class="bx bx-edit-alt" title="Edit data"></i>
                                                            </button>
                                                            <form action="/harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form action="/submit_harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                method="post" class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($hargabbmjbu->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info"
                                                                id="" data-bs-toggle="modal"
                                                                data-bs-target="#lihat-harga-bbm"
                                                                onclick="lihatHargaBBM('{{ $hargabbmjbu->id }}')"
                                                                data-id="{{ $hargabbmjbu->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($hargabbmjbu->status == '2')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editHarga"
                                                                onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}')"
                                                                id="editharga" data-bs-toggle="modal"
                                                                data-bs-target="#edit-hargabbm"
                                                                data-id="{{ $hargabbmjbu->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            <form action="/submit_harga-bbm-jbu/{{ $hargabbmjbu->id }}"
                                                                method="post" class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif

                                                    <center>
                                                        @if ($hargabbmjbu->status == 1 && $hargabbmjbu->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($hargabbmjbu->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($hargabbmjbu->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $hargabbmjbu->id }}">
                                                                Cek Revisi
                                                            </span>

                                                            <div class="modal fade"
                                                                id="modal-updateStatus-{{ $hargabbmjbu->id }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="staticBackdropLabel">Catatan Revisi</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <label for="notes">Notes</label>
                                                                            <textarea id="notes" cols="5" rows="5" class="form-control" disabled>{{ $hargabbmjbu->catatan }}</textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </center>

                                                </td>
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

            {{-- Harga LPG --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Harga LPG
                                </h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" onclick="produk(); provinsi();"
                                        data-bs-target="#inputHargaLPG">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelhbjbu">Import Excel</button>
                                    @include('badan_usaha.niaga.lpg.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table2" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Sektor</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten / Kota</th>
                                            <th>Volume</th>
                                            <th>Biaya Perolehan</th>
                                            <th>Biaya Distribusi</th>
                                            <th>Biaya Penyimpanan</th>
                                            <th>Margin</th>
                                            <th>PPN</th>
                                            <th>Harga Jual</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hargaLPG as $hargaLPG)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $hargaLPG->bulan }}</td>
                                                <td>{{ $hargaLPG->sektor }}</td>
                                                <td>{{ $hargaLPG->provinsi }}</td>
                                                <td>{{ $hargaLPG->kabupaten_kota }}</td>
                                                <td>{{ $hargaLPG->volume }}</td>
                                                <td>{{ $hargaLPG->biaya_perolehan }}</td>
                                                <td>{{ $hargaLPG->biaya_distribusi }}</td>
                                                <td>{{ $hargaLPG->biaya_penyimpanan }}</td>
                                                <td>{{ $hargaLPG->margin }}</td>
                                                <td>{{ $hargaLPG->ppn }}</td>
                                                <td>{{ $hargaLPG->harga_jual }}</td>
                                                <td>
                                                    @if ($hargaLPG->status == '0' || $hargaLPG->status == '-' || $hargaLPG->status == '')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editHarga"
                                                                onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}')"
                                                                id="editharga" data-bs-toggle="modal"
                                                                data-bs-target="#editHargaLPG"
                                                                data-id="{{ $hargaLPG->id }}">
                                                                <i class="bx bx-edit-alt" title="Edit data"></i>
                                                            </button>
                                                            <form action="/hapusHargaLPG/{{ $hargaLPG->id }}"
                                                                method="post" class="d-inline">
                                                                @method('delete')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="hapusData($(this).closest('form'))">
                                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                                </button>
                                                            </form>
                                                            <form action="/submitHargaLPG/{{ $hargaLPG->id }}"
                                                                method="post" class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @elseif($hargaLPG->status == '1')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info"
                                                                id="" data-bs-toggle="modal"
                                                                data-bs-target="#lihat-harga-lpg"
                                                                onclick="lihatHargaLPG('{{ $hargaLPG->id }}')"
                                                                data-id="{{ $hargaLPG->id }}">
                                                                <i class="bx bx-show-alt" title="Lihat data"></i>
                                                            </button>
                                                        </center>
                                                    @elseif($hargaLPG->status == '2')
                                                        <center>
                                                            <button type="button" class="btn btn-sm btn-info editHarga"
                                                                onclick="edit_hargaLPG('{{ $hargaLPG->id }}', '{{ $hargaLPG->kabupaten_kota }}')"
                                                                id="editharga" data-bs-toggle="modal"
                                                                data-bs-target="#editHargaLPG"
                                                                data-id="{{ $hargaLPG->id }}"> <i class="bx bx-edit-alt"
                                                                    title="Edit data"></i>
                                                            </button>
                                                            <form action="/submitHargaLPG/{{ $hargaLPG->id }}"
                                                                method="post" class="d-inline">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    onclick="kirimData($(this).closest('form'))">
                                                                    <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                                </button>
                                                            </form>
                                                        </center>
                                                    @endif

                                                    <center>
                                                        @if ($hargaLPG->status == 1 && $hargaLPG->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($hargaLPG->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($hargaLPG->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $hargaLPG->id }}">
                                                                Cek Revisi
                                                            </span>

                                                            <div class="modal fade"
                                                                id="modal-updateStatus-{{ $hargaLPG->id }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="staticBackdropLabel">Catatan Revisi
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <label for="notes">Notes</label>
                                                                            <textarea id="notes" cols="5" rows="5" class="form-control" disabled>{{ $hargaLPG->catatan }}</textarea>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </center>

                                                </td>
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
    {{--  <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
@endsection
