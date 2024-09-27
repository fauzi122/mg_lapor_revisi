<div class="row">
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
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($hargabbmjbu as $data)
                                @php    
                                $id=Crypt::encryptString($data->bulan_peb.','.$data->badan_usaha_id);                                    
                                @endphp
                                <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b><a href="/eksport-import/show/{{$id}}/ekspor">{{dateIndonesia($data->bulan_peb)}}<i class="bx bx-check" title="lihat data laporan"></i></a><b></td>
                                        <td>		
                                        @if ($data->status_tertinggi == 1 && $data->catatanx)
                                                <span class="badge bg-warning">Sudah Diperbaiki</span>
                                            @elseif ($data->status_tertinggi == 1)
                                                 <span class="badge bg-success">Kirim</span> 
                                            @elseif ($data->status_tertinggi == 2)
                                                <span class="badge bg-danger">Revisi</span>
                                            @elseif ($data->status_tertinggi == 0)
                                                <span class="badge bg-info">draf</span>
                                        @endif
                                        </td>
                                        <!-- <td>{{ $data->catatan }}</td> -->

                                        @if ($data->status_tertinggi == 1)
                                        <td><form action="/hapus_bulan_export/{{ $data->bulan_peb }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_export/{{$data->bulan_peb }}" method="post" class="d-inline" data-id="{{ $data->bulan_peb }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))" disabled>
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form></td>
                                        @else
                                        <td><form action="/hapus_bulan_export/{{ $data->bulan_peb }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                            </form>
                                            <form action="/submit_bulan_export/{{$data->bulan_peb }}" method="post" class="d-inline" data-id="{{ $data->bulan_peb }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            <a href="/eksport-import/show/{{$id}}/ekspor" class="btn btn-sm btn-info"><i class="bx bx-edit" title="Revisi"></i></a>
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