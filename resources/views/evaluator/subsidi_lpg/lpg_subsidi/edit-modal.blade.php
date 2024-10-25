<!-- Modal Edit Kuota -->
<div class="modal fade" id="editKuotaModal" tabindex="-1" role="dialog" aria-labelledby="editKuotaModalLabel" aria-hidden="true">
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
                        {{-- <select class="form-control" name="bulan" id="editBulan" required>
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
                        </select> --}}
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
</div>
