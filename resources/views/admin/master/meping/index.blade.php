@extends('layouts.blackand.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Data Detail Jenis Izin</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                        <li class="breadcrumb-item active">Data Detail Jenis Izin</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="penjualan">
                            <div class="table-responsive">
    <!-- ... (kode sebelumnya) ... -->
    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>Status</th> <!-- Tambahkan kolom untuk checkbox -->
                <th>Id Sub Page</th>
                <th>Id Templet</th>
                <th>Nama Opsi</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
        
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($meping as $meping)
            <tr>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script>
                                                $(document).ready(function () {
                                                    $('.status-checkbox').change(function () {
                                                        const id = $(this).data('id');
                                                        const status = $(this).prop('checked') ? 1 : 0;
                                        
                                                        $.ajax({
                                                            method: 'POST',
                                                            url: '{{ route("update-status") }}',
                                                            data: { id: id, status: status, _token: '{{ csrf_token() }}' },
                                                            success: function (response) {
                                                                console.log('Status updated successfully:', response.message);
                                                            },
                                                            error: function (xhr, status, error) {
                                                                console.error('Error updating status:', error);
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <td class="text-center">
                                                <input type="checkbox" class="status-checkbox" data-id="{{ $meping->id }}" {{ $meping->status ? 'checked' : '' }}>
                                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                                            </td>
                <td>{{ $meping->id_sub_page }}</td>
                <td>{{ $meping->id_template }}</td>
                <td style="width: 15px; height: 50px;">{{ $meping->nama_opsi }}</td>
                <td>{{ $meping->nama_menu }}</td>
                
                <td>
                    @if($meping->kategori == 1)
                    Gas
                    @elseif($meping->kategori == 2)
                    Minyak
                    @else
                    Kategori tidak dikenali
                    @endif
                </td>

                <td class="text-nowrap" align="center">
                    <a href="/master/meping/{{ $meping->id }}/edit">
                        <button type="button" class="btn btn-info waves-effect waves-light">
                            <i class="fa fa-edit"></i>
                        </button>
                    </a>
                    <form action="/master/meping/{{ $meping->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger waves-effect waves-light" onclick="return confirm('Yakin ingin menghapus data?')">
                            <i class="bx bx-trash-alt"></i>
                        </button>
                    </form>
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
@endsection


