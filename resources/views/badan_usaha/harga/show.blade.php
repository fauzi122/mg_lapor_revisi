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
                                    <button type="button" class="btn btn-sm btn-info editHarga" onclick="edit_harga('{{ $hargabbmjbu->id }}')" id="editharga" data-bs-toggle="modal" data-bs-target="#edit-hargabbm" data-id="{{ $hargabbmjbu->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                    
                                    <form action="/harga-bbm-jbu/{{ $hargabbmjbu->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data?')">
                                            <i class="bx bx-trash-alt"></i>
                                        </button>
                                    </form>
                                    <form action="/submit_pasokan-olah/{{ $hargabbmjbu->id }}" method="post" class="d-inline">
                                    @csrf
                                        <button class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin submit data?')">
                                            <i class="bx bx-paper-plane"></i>
                                        </button>
                                    </form>
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
</div>