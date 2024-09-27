@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Pasokan Hasil Olahan/Minyak Bumi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Laporan Pasokan Hasil Olahan/Minyak Bumi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
 @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-filter">
                                Data Filter
                            </button>
							<!-- Modal -->
							<div class="modal fade" id="modal-filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
							  <div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="staticBackdropLabel">Data Filter</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<form action="{{ url('/laporan/pasokan-hasil-olahan') }}" method="post" id="myform" enctype="multipart/form-data">
									@csrf
									<div class="modal-body">
										<label for="">Badan Usaha</label>
										<select name="badan_usaha" id="badan_usaha" class="form-control">
											<option value="">--Pilih Badan Usaha--</option>
											@foreach ($bu as $data_bu)
												<option class="text-center" value="{{ $data_bu['NAMA_PERUSAHAAN'] }}">{{ $data_bu['NAMA_PERUSAHAAN'] }}</option>
											@endforeach
										</select>
										<br>
										<label for="">Produk</label>
										<select name="produk" id="produk" class="form-control">
											<option value="">--Pilih Produk--</option>
											@foreach ($produk as $data_produk)
												<option class="text-center" value="{{ $data_produk['produk'] }}">{{ $data_produk['produk'] }}</option>
											@endforeach
										</select>
										<br>
										<label for="">Kabupaten/kota</label>
										<select name="kab_kota" id="kab_kota" class="form-control">
											<option value="">--Pilih Kabupaten/Kota--</option>
											@foreach ($kota as $data_kota)
												<option class="text-center" value="{{ $data_kota['kabupaten_kota'] }}">{{ $data_kota['kabupaten_kota'] }}</option>
											@endforeach
										</select>
										<label for="">Bulan</label>
										<div class="input-group mb-2 mr-sm-2 form-inline">
											<input class="form-control" type="month" id="example-text-input" name="bulan1" value="{{ old('bulan1') }}">
											<input class="form-control" type="month" id="example-text-input" name="bulan2" value="{{ old('bulan2') }}">
										</div>
										<span class="text text-danger">*Bulan tidak boleh kosong</span>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                                <th>Provinsi</th>
                                                <th>Kab/Kota</th>
                                                <th>Sektor</th>
                                                <th>Volume</th>
                                                <th>Satuan</th>
                                                <th>Petugas</th>
                                                <th>Catatan</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($query as $item)
                                            <tr>
                                            
                                                <td>{{ $item->NAMA_PERUSAHAAN }}</td>
												<td>
													@if ($item->status == 1 && $item->catatan)
                                                        <span class="badge bg-warning">Sudah Diperbaiki</span>
                                                    @elseif ($item->status == 1)
                                                        {{--  <span class="badge bg-success">Kirim</span>  --}}
                                                    @elseif ($item->status == 2)
                                                        <span class="badge bg-danger">Revisi</span>
                                                    @endif
												</td>
                                                <td>{{ dateIndonesia($item->bulan) }}</td>
                                                <td>{{ $item->produk }}</td>
                                                <td>{{ $item->provinsi }}</td>
                                                <td>{{ $item->kabupaten_kota }}</td>
                                                <td>{{ $item->sektor }}</td>
                                                <td>{{ $item->volume }}</td>
                                                <td>{{ $item->satuan }}</td>
                                                <td>{{ $item->petugas }}</td>
                                                <td>{{ $item->catatan }}</td>
												<td>
													<!-- Button trigger modal -->
													<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-updateStatus{{$item->id}}">
													Update Status
													</button>
													
													{{-- @if ($item->status == 2)
                                                        <!-- Button trigger modal -->
														<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-catatan{{$item->id}}">
														Lihat Catatan
														</button>
                                                    @endif --}}
													
													<!-- Modal -->
													<div class="modal fade" id="modal-updateStatus{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<form action="{{ url('/laporan/pasokan-hasil-olahan/update-revision/'.$item->id) }}" method="post" id="myform" enctype="multipart/form-data">															
															@csrf
															@method('put')
															<div class="modal-body">
																<label for="">Notes</label>
																<textarea name="catatan" id="" cols="5" rows="5" class="form-control"></textarea>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-primary">Update</button>
															</div>
															</form>
														</div>
													</div>
													</div>
													
													<!-- Modal -->
													<div class="modal fade" id="modal-catatan{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
													<div class="modal-dialog modal-md">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="staticBackdropLabel">Catatan</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body">
																{{$item->catatan}}
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.12/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.2.12/js/dataTables.responsive.min.js"></script>

<!-- CSS for DataTables and its extensions -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- DataTables and its extensions -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.74/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.74/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
    $('#datatable-buttons').DataTable({
			"order": [],
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv',
				{
					extend: 'excel',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				},
				'pdf', 'print'
			],

			columnDefs: [{
				targets: [3],
				visible: false
			}]
		});
	});
</script> --}}
<script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });
</script>
@endsection
