{{-- Tambah Data Modal --}}

<div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
  <!--begin::Modal dialog-->
  <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content rounded">  
        <div class="modal-header" id="kt_modal_new_target_header">
            <!--begin::Modal title-->
            <h2 class="fw-bold">Tambah Data LPG Subsidi Verified</h2>
            <!--end::Modal title-->
            <!--begin::Close-->
            <div id="kt_modal_new_target_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                <i class="ki-outline ki-cross fs-1"></i>
            </div>
            <!--end::Close-->
        </div>  
            <form action="/lpg/subsidi/store" method="post" id="myform" enctype="multipart/form-data">
            @csrf
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="kt_modal_new_target_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_target_header" data-kt-scroll-wrappers="#kt_modal_new_target_scroll" data-kt-scroll-offset="300px">
                        <div class="fv-row mb-7">
                            <label for="bulan" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Bulan</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Untuk Mengganti Tahun Gunakan Scroll Ke atas atau bawah">
                                    <i class="ki-outline ki-information fs-7"></i>
                                </span>
                            </label>
                            <input class="form-control mb-2" type="month" id="editBulan" name="bulan"  required>
                        </div>
                        <div class="fv-row mb-7">
                            <label for="provinsi" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Provinsi</span>
                            </label>
                            <select name="provinsi" id="provinsi"
                                    class="form-control mb-2"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="">--Pilih Provinsi--</option>
                                @foreach ($provinsi as $prov)
                                    <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label for="volume" class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">Volume</span>
                            </label>
                            <input class="form-control mb-2" type="number" min=0 id="volume" name="volume" required>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
      </div>
  </div>
</div>

{{-- End Tambah Data Modal --}}
















{{-- <form action="/lpg/subsidi/store" method="post" id="myform"
enctype="multipart/form-data">

@csrf
<div class="mb-3">
  <label for="bulan">Bulan*</label>
  <select class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%;" tabindex="-1" aria-hidden="true"
          name="bulan">
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
  <input class="form-control mb-2" type="month" id="editBulan" name="bulan"  required>

</div>
<div class="mb-3">
  <label for="provinsi">Provinsi*</label>
  <select name="provinsi" id="provinsi"
          class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%;" tabindex="-1" aria-hidden="true">
      <option value="">--Pilih Provinsi--</option>
      @foreach ($provinsi as $prov)
          <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
      @endforeach
  </select>
</div>
<div class="mb-3">
  <label for="volume">Volume*</label>
  <input class="form-control mb-2" type="number" min=0 id="volume"
         name="volume" required>
</div>
<div class="mb-3">
  <button type="submit" class="btn btn-primary btn-rounded"> Simpan</button>
</div>
</form> --}}