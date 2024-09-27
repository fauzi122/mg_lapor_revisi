@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Hasil Olahan/Minyak Bumi</h4>
                    </div>
                </div>
            </div>
            {{-- penjualan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Penjualan Hasil Olahan/Minyak Bumi</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#myModal">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                    <!-- Include modal content -->
                                    @include('badan_usaha.niaga.hasil_olahan.modal')
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($show_jholbx as $show_jholbx)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $show_jholbx->bulan }}</td>
                                                <td>{{ $show_jholbx->produk }}</td>
                                                <td>{{ $show_jholbx->provinsi }}</td>
                                                <td>{{ $show_jholbx->kabupaten_kota }}</td>
                                                <td>{{ $show_jholbx->sektor }}</td>
                                                <td>{{ $show_jholbx->volume }}</td>
                                                <td>{{ $show_jholbx->satuan }}</td>
                                                <td>

                                                    <?php
                                            $status=$show_jholbx->status;
                                            if ($status=="0"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPenjualan"
                                                            id="editCompany"
                                                            onclick="editPenjualan('{{ $show_jholbx->id }}', '{{ $show_jholbx->produk }}' , '{{ $show_jholbx->kabupaten_kota }}')"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                            data-id="{{ $show_jholbx->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit data"></i></button>
                                                        <form action="/hapus_jholb/{{ $show_jholbx->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form action="/submit_jholb/{{ $show_jholbx->id }}" method="post"
                                                            class="d-inline" data-id="{{ $show_jholbx->id }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                    </center>
                                                    </form>

                                                    <?php 
                                            }elseif ($status=="1"){ ?>
                                                    <form action="/submit_jholb/{{ $show_jholbx->id }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        <center><button type="button" class="btn btn-sm btn-info "
                                                                id="" data-bs-toggle="modal"
                                                                onclick="lihat_jholb('{{ $show_jholbx->id }}', '{{ $show_jholbx->produk }}' , '{{ $show_jholbx->kabupaten_kota }}')"
                                                                data-bs-target="#lihat-penjualan"
                                                                data-id="{{ $show_jholbx->id }}"> <i class="bx bx-show-alt"
                                                                    title="Lihat data"></i></button></center>
                                                    </form>
                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPenjualan"
                                                            id="editCompany"
                                                            onclick="editPenjualan('{{ $show_jholbx->id }}', '{{ $show_jholbx->produk }}' , '{{ $show_jholbx->kabupaten_kota }}')"
                                                            data-bs-toggle="modal" data-bs-target="#modal-edit"
                                                            data-id="{{ $show_jholbx->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit data"></i></button>
                                                        <form action="/submit_jholb/{{ $show_jholbx->id }}" method="post"
                                                            class="d-inline">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                    </center>
                                                    </form>
                                                    <?php 
                                            } ?>
                                                    <center>
                                                        @if ($show_jholbx->status == 1 && $show_jholbx->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($show_jholbx->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($show_jholbx->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $show_jholbx->id }}">
                                                                Cek Revisi
                                                            </span>

                                                            <div class="modal fade"
                                                                id="modal-updateStatus-{{ $show_jholbx->id }}"
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
                                                                            <textarea id="notes" cols="5" rows="5" class="form-control" disabled>{{ $show_jholbx->catatan }}</textarea>
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
                                                    <div class="modal fade" id="revisiModal" tabindex="-1"
                                                        aria-labelledby="revisiModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="revisiModalLabel">Catatan
                                                                        Revisi</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="revisiCatatan">
                                                                    <!-- Catatan revisi akan ditampilkan di sini -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
            {{-- pasokan --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Pasokan Hasil Olahan/Minyak Bumi</h5>
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        onclick="produk(); provinsi();" data-bs-toggle="modal"
                                        data-bs-target="#inputpho">Buat Laporan</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#excelpholb">Import Excel</button>
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
                                            <th>Produk</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Sektor</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pasokan as $pasokan)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pasokan->bulan }}</td>
                                                <td>{{ $pasokan->produk }}</td>
                                                <td>{{ $pasokan->provinsi }}</td>
                                                <td>{{ $pasokan->kabupaten_kota }}</td>
                                                <td>{{ $pasokan->sektor }}</td>
                                                <td>{{ $pasokan->volume }}</td>
                                                <td>{{ $pasokan->satuan }}</td>
                                                <td>
                                                    <?php
                                            $status=$pasokan->status;
                                            if ($status=="0"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPasokan"
                                                            id="editpasokan" data-bs-toggle="modal"
                                                            data-bs-target="#edit-pasokan"
                                                            onclick="editPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')"
                                                            data-id="{{ $pasokan->id }}"> <i class="bx bx-edit-alt"
                                                                title="Edit data"></i></button>
                                                        <form action="/pasokan-olah/{{ $pasokan->id }}" method="post"
                                                            class="d-inline">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="hapusData($(this).closest('form'))">
                                                                <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                            </button>
                                                        </form>
                                                        <form action="/submit_pasokan-olah/{{ $pasokan->id }}"
                                                            method="post" class="d-inline"
                                                            data-id="{{ $pasokan->id }}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                    </center>
                                                    </form>

                                                    <?php 
                                            }elseif ($status=="1"){ ?>

                                                    <center><button type="button" class="btn btn-sm btn-info"
                                                            id="" data-bs-toggle="modal"
                                                            data-bs-target="#lihat-pasokan-olah"
                                                            onclick="lihatPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')"
                                                            data-id="{{ $pasokan->id }}"> <i class="bx bx-show-alt"
                                                                title="Lihat data"></i></button></center>

                                                    <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editPasokan"
                                                            id="editpasokan" data-bs-toggle="modal"
                                                            data-bs-target="#edit-pasokan" onclick="editPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')" data-id="{{ $pasokan->id }}">
                                                            <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                        <form action="/submit_pasokan-olah/{{ $pasokan->id }}"
                                                            method="post" class="d-inline">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button>
                                                    </center>
                                                    </form>
                                                    <?php 
                                            } ?>
                                                    <center>
                                                        @if ($pasokan->status == 1 && $pasokan->catatan)
                                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                        @elseif ($pasokan->status == 1)
                                                            <span class="badge bg-success">Kirim</span>
                                                        @elseif ($pasokan->status == 2)
                                                            <span class="badge bg-danger" data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus-{{ $pasokan->id }}">
                                                                Cek Revisi
                                                            </span>

                                                            <div class="modal fade"
                                                                id="modal-updateStatus-{{ $pasokan->id }}"
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
                                                                            <textarea id="notes" cols="5" rows="5" class="form-control" disabled>{{ $pasokan->catatan }}</textarea>
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
            {{-- harga --}}
            {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Harga BBM JBU</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" onclick="produk(); provinsi();" data-bs-target="#inputhbjbu">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelhbjbu">Import Excel</button>
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

                                        <?php
                                            $status=$pasokan->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info editHarga" onclick="edit_hargabbmx('{{ $hargabbmjbu->id }}' , '{{ $hargabbmjbu->produk }}' , '{{ $hargabbmjbu->kabupaten_kota }}')" id="editharga" data-bs-toggle="modal" data-bs-target="#edit-hargabbm" data-id="{{ $hargabbmjbu->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/harga-bbm-jbu/{{ $hargabbmjbu->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_pasokan-olah/{{ $hargabbmjbu->id }}" method="post" class="d-inline">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                
                                            <?php 
                                            }elseif ($status=="1"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info" id="" data-bs-toggle="modal" data-bs-target="#lihat-pasokan-olah" onclick="lihatPasokan('{{ $pasokan->id }}', '{{ $pasokan->produk }}' , '{{ $pasokan->kabupaten_kota }}')" data-id="{{ $pasokan->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>                   
                                            <?php 
                                            }elseif ($status=="2"){ ?>
                                                    <center><button type="button" class="btn btn-sm btn-info editHarga" onclick="edit_harga('{{ $hargabbmjbu->id }}')" id="editharga" data-bs-toggle="modal" data-bs-target="#edit-hargabbm" data-id="{{ $hargabbmjbu->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>  
                                                    <form action="/submit_pasokan-olah/{{ $hargabbmjbu->id }}" method="post" class="d-inline">
                                                    @method('PUT')
                                                    @csrf
                                                        <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                            <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                        </button></center>
                                                    </form>
                                            <?php 
                                            } ?>

                                    <center>
                                        @if ($hargabbmjbu->status == 1 && $hargabbmjbu->catatan)
                                            <span class="badge bg-warning">Sudah Diperbaiki</span>
                                        @elseif ($hargabbmjbu->status == 1)
                                            <span class="badge bg-success">Kirim</span>
                                        @elseif ($hargabbmjbu->status == 2)
                                            <span class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#modal-updateStatus-{{ $hargabbmjbu->id }}">
                                                Cek Revisi
                                            </span>

                                            <div class="modal fade" id="modal-updateStatus-{{ $hargabbmjbu->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Catatan Revisi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label for="notes">Notes</label>
                                                            <textarea id="notes" cols="5" rows="5" class="form-control" disabled>{{ $hargabbmjbu->catatan }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        </div> --}}
        </div>
    </div>
    {{--  <script>
    document.querySelector('.btn-primary').addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>  --}}
@endsection
