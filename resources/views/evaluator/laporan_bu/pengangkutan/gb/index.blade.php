@extends('layouts.blackand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Laporan Pengangkutan Gas Bumi</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                                <li class="breadcrumb-item active">Laporan Pengangkutan Gas Bumi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-end mb-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-filter">
                                    Data Filter
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modal-filter" data-bs-backdrop="static" data-bs-keyboard="false"
                                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Data Filter</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ url('/laporan/pengangkutan/gb') }}" method="post"
                                                id="myform" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label for="">Badan Usaha</label>
                                                    <select name="badan_usaha" id="badan_usaha" class="form-control">
                                                        <option value="">--Pilih Badan Usaha--</option>
                                                        @foreach ($bu as $data_bu)
                                                            <option class="text-center"
                                                                value="{{ $data_bu['NAMA_PERUSAHAAN'] }}">
                                                                {{ $data_bu['NAMA_PERUSAHAAN'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <br>
                                                    <label for="">Produk</label>
                                                    <select name="produk" id="produk" class="form-control">
                                                        <option value="">--Pilih Produk--</option>
                                                        <option value="all"> Semua Perusahaan </option>

                                                        @foreach ($produk as $data_produk)
                                                            <option class="text-center"
                                                                value="{{ $data_produk['produk'] }}">
                                                                {{ $data_produk['produk'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <br>
                                                    <label for="">Bulan</label>
                                                    <div class="input-group mb-2 mr-sm-2 form-inline">
                                                        <input class="form-control" type="month" id="example-text-input"
                                                            name="bulan1" value="{{ old('bulan1') }}">
                                                        <input class="form-control" type="month" id="example-text-input"
                                                            name="bulan2" value="{{ old('bulan2') }}">
                                                    </div>
                                                    <span class="text text-danger">*Bulan tidak boleh kosong</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs">


                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="penjualan">
                                    <div class="table-responsive">
                                        <table id="datatable-buttons" class="table table-bordered nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Nama Badan Usaha</th>
                                                    <th>Status</th>
                                                    <th>Bulan</th>
                                                    <th>Produk</th>
                                                    <th>Jenis Moda</th>
                                                    <th>Node Asal</th>
                                                    <th>Provinsi Asal</th>
                                                    <th>Node Tujuan</th>
                                                    <th>Provinsi Tujuan</th>
                                                    <th>Vol Suplai</th>
                                                    <th>Satuan Vol Suplai</th>
                                                    <th>Vol Angkut</th>
                                                    <th>Satuan Vol Angkut</th>
                                                    <th>Catatan</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($query as $data)
                                                    <tr>
                                                        <td>{{ $data->NAMA_PERUSAHAAN }}</td>
                                                        <td>
                                                            @if ($data->status == 1 && $data->catatan)
                                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                            @elseif ($data->status == 1)
                                                                {{--  <span class="badge bg-success">Diterima</span>  --}}
                                                            @elseif ($data->status == 2)
                                                                <span class="badge bg-danger">Revisi</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ dateIndonesia($data->created_at) }}</td>
                                                        <td>{{ $data->produk }}</td>
                                                        <td>{{ $data->jenis_moda }}</td>
                                                        <td>{{ $data->node_asal }}</td>
                                                        <td>{{ $data->provinsi_asal }}</td>
                                                        <td>{{ $data->node_tujuan }}</td>
                                                        <td>{{ $data->provinsi_tujuan }}</td>
                                                        <td>{{ $data->volume_supply }}</td>
                                                        <td>{{ $data->satuan_volume_supply }}</td>
                                                        <td>{{ $data->volume_angkut }}</td>
                                                        <td>{{ $data->satuan_volume_angkut }}</td>
                                                        <td>{{ $data->catatan }}</td>
                                                        <td>
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-updateStatus{{ $data->id }}">
                                                                Update Status
                                                            </button>

                                                            <!-- @if ($data->status == 2)
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-catatan{{ $data->id }}">
                  Lihat Catatan
                  </button>
    @endif -->

                                                            <!-- Modal -->
                                                            <div class="modal fade"
                                                                id="modal-updateStatus{{ $data->id }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="staticBackdropLabel">Update Status</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ url('/laporan/pengangkutan/gb/update-revision/' . $data->id) }}"
                                                                            method="post" id="myform"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            @method('put')
                                                                            <div class="modal-body">
                                                                                <label for="">Notes</label>
                                                                                <textarea name="catatan" id="" cols="5" rows="5" class="form-control"></textarea>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Update</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modal-catatan{{ $data->id }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="staticBackdropLabel">Catatan</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $data->catatan }}
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
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
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endsection
