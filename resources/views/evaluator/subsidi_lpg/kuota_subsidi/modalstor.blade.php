<form action="/lpg/kuota/store" method="post" id="myform"
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
</div>
<div class="mb-3">
  <label for="provinsi">Provinsi*</label>
  <select name="provinsi" id="provinsiTambah"
          class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%;" tabindex="-1" aria-hidden="true">
      <option value="">--Pilih Provinsi--</option>
      @foreach ($provinsi as $prov)
          <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
      @endforeach
  </select>
</div>

<div class="mb-3">
  <label for="kabkot">Kabupaten/Kota*</label>
  <select name="kabkot" id="kabkotTambah"
          class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%; display: none" tabindex="-1" aria-hidden="true" >
      <option value="">--Pilih Kabupaten--</option>

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
</form>