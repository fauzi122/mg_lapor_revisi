@extends('layouts.frontand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Bahan Bakar Minyak</h4>
                </div>
            </div>
        </div>

        {{-- harga --}}
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

                {{-- expor impor --}}
        {{-- expor --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Ekspor</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#modal-ekspor">Buat Laporan.</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelpho">Import Excel</button>
                                <!-- Include modal content -->
                                @include('badan_usaha.ekspor_impor.modal')
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table4" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PEB</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PEB</th>
                                        <th>Satuan</th>
                                        <th>Invoice Amount Nilai Pabean</th>
                                        <th>Invoice Amount Final</th>
                                        <th>Nama Konsumen</th>
                                        <th>Pelabuhan Muat</th>
                                        <th>Negara Tujuan</th>
                                        <th>Vessel Name</th>
                                        <th>Tanggal BL</th>
                                        <th>BL No</th>
                                        <th>No Pendaftaran PEB</th>
                                        <th>Tanggal Pendaftaran PEB</th>
                                        <th>Incoterms</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expor as $expor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expor->bulan_peb }}</td>
                                        <td>{{ $expor->produk }}</td>
                                        <td>{{ $expor->hs_code }}</td>
                                        <td>{{ $expor->volume_peb }}</td>
                                        <td>{{ $expor->satuan }}</td>
                                        <td>{{ $expor->invoice_amount_nilai_pabean }}</td>
                                        <td>{{ $expor->invoice_amount_final }}</td>
                                        <td>{{ $expor->nama_konsumen }}</td>
                                        <td>{{ $expor->pelabuhan_muat }}</td>
                                        <td>{{ $expor->negara_tujuan }}</td>
                                        <td>{{ $expor->vessel_name }}</td>
                                        <td>{{ $expor->tanggal_bl }}</td>
                                        <td>{{ $expor->bl_no }}</td>
                                        <td>{{ $expor->no_pendaf_peb }}</td>
                                        <td>{{ $expor->tanggal_pendaf_peb }}</td>
                                        <td>{{ $expor->incoterms }}</td>
                                        <td>
                                            
                                            <?php
                                            $status=$expor->status;
                                            if ($status=="0"){ ?>
                                                <center><button type="button" class="btn btn-sm btn-info editEkpor" id="editCompany" onclick="edit_ekpor('{{ $expor->id }}', '{{ $expor->produk }}' )" data-bs-toggle="modal" data-bs-target="#modal-edit-ekspor" data-id="{{ $expor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                                <form action="/hapus_export/{{ $expor->id }}" method="post" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                        <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                    </button>
                                                </form>
                                                <form action="/submit_export/{{ $expor->id }}" method="post" class="d-inline" data-id="{{ $expor->id }}">
                                                @method('PUT')
                                                @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                                </form>
                                                
                                            <?php 
                                            }elseif ($status=="1"){ ?>
                                                      
                                                        <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_ekspor('{{ $expor->id }}' , '{{ $expor->produk }}')" data-bs-target="#lihat-ekspor" data-id="{{ $expor->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                                      
                                            <?php 
                                            }elseif ($status=="2"){ ?>
                                                        <center><button type="button" class="btn btn-sm btn-info editPenjualan" id="editCompany" onclick="edit_penjualan_gbp('{{ $expor->id }}' )" data-bs-toggle="modal" data-bs-target="#modal-edit" data-id="{{ $exporexpor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>  
                                                        <form action="/submit_export/{{ $expor->id }}" method="post" class="d-inline">
                                                        @method('PUT')
                                                        @csrf
                                                            <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                                <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                            </button></center>
                                                        </form>
                                            <?php 
                                            } ?>
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
        {{-- impor --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Impor</h5>
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="produk(); provinsi();" data-bs-toggle="modal" data-bs-target="#inputimpor">Buat Laporan</button>
                                <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#excelpholb">Import Excel</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table5" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan PIB</th>
                                        <th>Produk</th>
                                        <th>HS Code</th>
                                        <th>Volume PIB</th>
                                        <th>Satuan</th>
                                        <th>Invoice Amount Nilai Pabean</th>
                                        <th>Invoice Amount Final</th>
                                        <th>Nama Supplier</th>
                                        <th>Negara Asal</th>
                                        <th>Pelabuhan Muat</th>
                                        <th>Pelabuhan Bongkar</th>
                                        <th>Vessel Name</th>
                                        <th>Tanggal BL</th>
                                        <th>BL NO</th>
                                        <th>No Pendaftaran PIB</th>
                                        <th>Tanggal Pendaftaran PIB</th>
                                        <th>Incoterms</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($impor as $impor)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $impor->bulan_pib }}</td>
                                        <td>{{ $impor->produk }}</td>
                                        <td>{{ $impor->hs_code }}</td>
                                        <td>{{ $impor->volume_pib }}</td>
                                        <td>{{ $impor->satuan }}</td>
                                        <td>{{ $impor->invoice_amount_nilai_pabean }}</td>
                                        <td>{{ $impor->invoice_amount_final }}</td>
                                        <td>{{ $impor->nama_supplier }}</td>
                                        <td>{{ $impor->negara_asal }}</td>
                                        <td>{{ $impor->pelabuhan_muat }}</td>
                                        <td>{{ $impor->pelabuhan_bongkar }}</td>
                                        <td>{{ $impor->vessel_name }}</td>
                                        <td>{{ $impor->tanggal_bl }}</td>
                                        <td>{{ $impor->bl_no }}</td>
                                        <td>{{ $impor->no_pendaf_pib }}</td>
                                        <td>{{ $impor->tanggal_pendaf_pib }}</td>
                                        <td>{{ $impor->incoterms }}</td>
                                        <td>
                                        <?php
                                        $status=$impor->status;
                                        if ($status=="0"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_impor('{{ $impor->id }}','{{ $expor->produk }}')" data-bs-target="#edit-impor" data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/hapus_import/{{ $impor->id }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-danger"  onclick="hapusData($(this).closest('form'))">
                                                    <i class="bx bx-trash-alt" title="Hapus data"></i>
                                                </button>
                                            </form>
                                            <form action="/submit_import/{{ $impor->id }}" method="post" class="d-inline" data-id="{{ $impor->id }}">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                            
                                       <?php }elseif ($status=="1"){ ?>
                                            
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="lihat_import('{{ $impor->id }}')" data-bs-target="#lihat-import" data-id="{{ $impor->id }}"> <i class="bx bx-show-alt" title="Lihat data"></i></button></center>
                                            
                                       <?php }elseif ($status=="2"){ ?>
                                            <center><button type="button" class="btn btn-sm btn-info " id="" data-bs-toggle="modal" onclick="edit_pasokan_gbp('{{ $impor->id }}')" data-bs-target="#edit-pasokan" data-id="{{ $impor->id }}"> <i class="bx bx-edit-alt" title="Edit data"></i></button>
                                            <form action="/submit_import/{{ $impor->id }}" method="post" class="d-inline">
                                            @method('PUT')
                                            @csrf
                                                    <button type="button" class="btn btn-sm btn-success" onclick="kirimData($(this).closest('form'))">
                                                        <i class="bx bx-paper-plane" title="Kirim data"></i>
                                                    </button></center>
                                            </form>
                                       <?php } ?>
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
