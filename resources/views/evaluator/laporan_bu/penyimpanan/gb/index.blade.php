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



            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div style="display:flex; margin:10px; justify-content:space-between">

                            <div class="card-header">
                                <h3>{{ $title }}</h3>
                            </div>

                            <div class="card-header">
                                <button type="button" class="btn btn-success waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"><i
                                        class='bx bx-printer'></i> Cetak
                                </button>
                                <a href="{{ url('/laporan/penyimpanan/gb-lihat-semua-data') }}"
                                    class="btn btn-info waves-effect waves-light">
                                    <i class='bx bx-file'></i>
                                    Lihat Semua Data
                                </a>

                                <div class="modal fade modal-select bs-example-modal-center" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cetak</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="cetakForm"
                                                    action="{{ url('laporan/penyimpanan/gb/cetak-periode') }}"
                                                    method="post">
                                                    @csrf
                                                    <div>
                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Nama
                                                                Perusahaan</label>
                                                            <select
                                                                class="form-control select20 select2-hidden-accessible mb-2"
                                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                                name="perusahaan" required>
                                                                <option value="">--Pilih Perusahaan--</option>
                                                                <option value="all"> Semua Perusahaan </option>

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
                                                                id="example-text-input" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="example-text-input" class="form-label">Tanggal
                                                                Akhir</label>
                                                            <input class="form-control" name="t_akhir" type="date"
                                                                value="Artisanal kale" id="example-text-input" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <button type="submit" data-bs-dismiss="modal"
                                                                class="btn btn-primary">Proses</button>
                                                        </div>


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
                                        <table id="datatable-buttons" class="table table-bordered nowrap w-100">
                                            <thead>

                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Perusahaan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($perusahaan as $per)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $per->NAMA_PERUSAHAAN }}</td>
                                                        <td><a href="{{ url('laporan/penyimpanan/gb/periode') . '/' . \Illuminate\Support\Facades\Crypt::encrypt($per->id_perusahaan) }}"
                                                                class="btn btn-primary btn-rounded btn-sm"><i
                                                                    class="bx bx-show"></i> Lihat </a></td>

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
@endsection
