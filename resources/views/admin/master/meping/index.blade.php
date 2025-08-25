@extends('layouts.blackand.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Data Detail Jenis Izin</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Master Data</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master/meping') }}" class="text-muted text-hover-primary">Jenis Izin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Data Detail Jenis Izin</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card-body p-3">
            <div class="card mb-5 mb-xl-8 shadow">
                <div class="card-header bg-light p-5">
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('/master/meping/create/' . $id . '/jenis-izin/'. $jenis_izin) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Input Jenis Izin">
                                    <i class="ki-duotone ki-plus"></i> Input Jenis Izin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="card">
                        @if (session()->has('success'))
                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <script>
                            swal("{{ session('success') }}", "", "success");
                            </script>
                        @endif
                        <div class="card-header align-items-center px-2">
                            <div class="card-toolbar"></div> 
                            <div class="card-title flex-row-fluid justify-content-end gap-5">
                                <input type="hidden" class="export-title" value="Data Detail Jenis Izin"/>
                            </div>
                        </div>
                        <table class="kt-datatable table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr class="fw-bold text-uppercase">
                                    {{-- <th class="text-center">No</th> --}}
                                    <th class="text-center">Status</th> <!-- Tambahkan kolom untuk checkbox -->
                                    <th class="text-center">Id Sub Page</th>
                                    <th class="text-center">Id Templet</th>
                                    <th class="text-center">Nama Opsi</th>
                                    <th class="text-center">Nama Menu</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Url</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($meping as $meping)
                                <tr>
                                    {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
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

                                    <td>{{ $meping->url }}</td>

                                    <td class="text-nowrap" align="center">
                                        <a href="{{ url('/master/meping/izin/'. $meping->id . '/edit') }}">
                                            <button type="button" class="btn btn-icon btn-sm btn-info mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                        <form action="{{ url('/master/meping/'. $meping->id .'/destroy') }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-icon btn-sm btn-danger mb-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus" onclick="return confirm('Yakin ingin menghapus data?')">
                                                <i class="bi bi-trash3-fill"></i>
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

{{-- <div class="page-content">
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
</div> --}}
@endsection
@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function () {
    $(document).on('change', '.status-checkbox', function () {
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
@endsection



