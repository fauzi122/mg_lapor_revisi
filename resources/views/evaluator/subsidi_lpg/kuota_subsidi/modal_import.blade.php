{{-- Import Excel Modal --}}

<div class="modal fade" id="kt_modal_new_excel" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_new_excel_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Import Excel Data LPG Subsidi Verified</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_modal_new_excel_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>

            <form action="/lpg/storekuota_excel" method="post" id="myform" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_excel_scroll" data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#kt_modal_new_excel_header"
                         data-kt-scroll-wrappers="#kt_modal_new_excel_scroll"
                         data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label for="bulan" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Bulan</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                            </label>
                            <input class="form-control mb-2" type="month" id="bulan" name="tahun" required>
                        </div>

                        <div class="fv-row mb-7">
                            <label for="file" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">File</span>
                            </label>
                            <input class="form-control mb-2" type="file" id="file" name="file" required>
                        </div>

                        <div class="modal-footer flex-center">
                            <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
                            <a href="/storage/template/kuota_lpg.xlsx" type="button" class="btn btn-success btn-rounded">Download Templet Excel</a>
                        </div>

                    </div>
                </div>
            </form>

        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>




{{-- <div class="modal fade" id="kt_modal_new_excel" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content rounded">
            <div class="modal-header" id="kt_modal_new_excel_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Import Excel Kuota Data LPG Subsidi Verified</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div id="kt_modal_new_excel_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <form action="/lpg/storekuota_excel" method="post" id="myform" enctype="multipart/form-data">
                @csrf
                <div class="modal-body py-10 px-lg-17">
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_excel_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_excel_header" data-kt-scroll-wrappers="#kt_modal_new_excel_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label for="bulan" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Bulan</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                            </label>
                            <input class="form-control mb-2" type="month" id="bulan" name="tahun" required>
                        </div>
                        <div class="fv-row mb-7">
                            <label for="file" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">File</span>
                            </label>
                            <input class="form-control mb-2" type="file" id="file" name="file" required>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
                            <a href="/storage/template/kuota_lpg.xlsx" type="button" class="btn btn-success btn-rounded">Download Templet Excel</a>
                        </div>
                    </div>
                    
                </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     --}}
<!-- Tambahkan link CSS dan JavaScript untuk Bootstrap dan Datepicker -->
