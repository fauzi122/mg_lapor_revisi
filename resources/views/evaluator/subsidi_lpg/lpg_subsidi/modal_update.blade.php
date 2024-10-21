<form action="/lpg/subsidi/update" method="post" id="myform"
enctype="multipart/form-data">

@csrf
<input type="hidden" name="id" value="{{$data->id}}">
<div class="mb-3">
  <label for="bulan">Bulan*</label> <br>
  <select class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%;" tabindex="-1" aria-hidden="true"
          name="bulan">
      <option value="{{$data->bulan}}">{{dateIndonesia($data->bulan)}}</option>
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
  <label for="provinsi">Provinsi*</label> <br>
  <select name="provinsi" id="provinsi"
          class="form-control select20 select2-hidden-accessible mb-2"
          style="width: 100%;" tabindex="-1" aria-hidden="true">
      <option value="{{$data->provinsi}}">{{$data->provinsi}}</option>
      <option value="">--Pilih Provinsi--</option>
      @foreach ($provinsi as $prov)
          <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
      @endforeach
  </select>
</div>
<div class="mb-3">
  <label for="volume">Volume*</label>
  <input class="form-control mb-2" type="number" id="volume"
         name="volume" min=0 value="{{$data->volume}}" required>
</div>
<div class="mb-3">
  <button type="submit" class="btn btn-warning btn-rounded"> Update</button>
</div>
</form>