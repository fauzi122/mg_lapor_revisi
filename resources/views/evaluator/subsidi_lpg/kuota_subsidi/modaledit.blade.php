<!-- Modal Edit Kuota -->

<div class="modal fade" id="kt_modal_edit" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_edit_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Kuota LPG Subsidi</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_modal_edit_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>

            <form action="" method="post" id="editKuotaForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_edit_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_edit_header"
                         data-kt-scroll-wrappers="#kt_modal_edit_scroll"
                         data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label for="editBulan" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Bulan</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                            </label>
                            <input class="form-control mb-2" type="month" id="editBulan" name="bulan" value="{{ substr($data->tahun, 0, 7) }}" required>
                        </div>

                        <div class="fv-row mb-7">
                            <label for="editProvinsi" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Provinsi</span>
                            </label>
                            <select name="provinsi" id="editProvinsi" class="form-control" required>
                                <option value="">--Pilih Provinsi--</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <label for="editKabkot" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Kabupaten/Kota</span>
                            </label>
                            <select name="kabkot" id="editKabkot" class="form-control" required>
                                <option value="">--Pilih Kabupaten/Kota--</option>
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <label for="editVolume" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Volume</span>
                            </label>
                            <input class="form-control" type="number" min="0" id="editVolume" name="volume" required>
                        </div>

                        <div class="modal-footer flex-center">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan Perubahan</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



{{-- <div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog" aria-labelledby="editKuotaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="post" id="editKuotaForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editKuotaModalLabel">Edit Kuota LPG Subsidi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editBulan">Bulan*</label>
                        <select class="form-control" name="bulan" id="editBulan" required>
                            <option value="">--Pilih Bulan--</option>
                             @php
                                $currentMonth = now();
                                $months = [];
                                for ($i = 0; $i < 15; $i++) {
                                    $formattedMonth = $currentMonth->format('Y-m-01');
                                    $months[$formattedMonth] = dateIndonesia($currentMonth->format('Y-m-01'));
                                    $currentMonth->subMonth();
                                }
                            @endphp
                            @foreach ($months as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <input class="form-control mb-2" type="month" id="editBulan" name="bulan" value="{{ substr($data->tahun, 0, 7) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProvinsi">Provinsi*</label>
                        <select name="provinsi" id="editProvinsi" class="form-control" required>
                            <option value="">--Pilih Provinsi--</option>
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editKabkot">Kabupaten/Kota*</label>
                        <select name="kabkot" id="editKabkot" class="form-control" required>
                            <option value="">--Pilih Kabupaten/Kota--</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editVolume">Volume*</label>
                        <input class="form-control" type="number" min="0" id="editVolume" name="volume" required>
                    </div>
                </div>
                <div class="modal-footer">
                
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
