<table class="kt-datatable table table-bordered table-hover">
    <thead class="bg-light">
        <tr class="fw-bold text-uppercase">
            <th>Izin</th>
            <th>Tanggal ACC</th>
            <th>Nomor Izin</th>
            <th>Menu Laporan</th>
        </tr>
    </thead>
    <tbody class="fw-semibold text-gray-600">
        @foreach ($result as $item)
            @php
                // Enkripsi parameter
                $encodedShow = Crypt::encryptString(implode(',', [
                    $item->id_permohonan ?? '',
                    $item->no_sk_izin ?? '',
                    $item->id_sub_page ?? '',
                    $item->kategori ?? '',
                    $item->id_izin ?? '',
                ]));
                $encodedShow = urlencode($encodedShow);

                // Normalisasi dan ambil info subpage
                $currentSubPage = collect($sub_page)->firstWhere('id_sub_page', $item->id_sub_page);
                $kategori = $currentSubPage->kategori ?? null;
                $nama_opsi = strtolower($currentSubPage->nama_opsi ?? '');

                // Normalisasi deskripsi izin
                $kodeIzin = strtolower($item->kode_izin_desc);

                // Penentuan jenis izin
                $isNiaga         = str_contains($kodeIzin, 'niaga');
                $isNiagaS        = str_contains($kodeIzin, 'niaga') && str_contains($kodeIzin, 'sementara');
                $isPengolahan    = str_contains($kodeIzin, 'pengolahan');
                $isPengangkutan  = str_contains($kodeIzin, 'pengangkutan');
                $isKusus         = $currentSubPage && $currentSubPage->id_sub_menu == 1;

                // Khusus LPG dan gas lainnya
                $isNiagaLPG = $isNiaga && $kategori == 1 && str_contains($nama_opsi, 'lpg');
                $isNiagaGasTanpaHarga = $isNiaga && $kategori == 1 && !$isNiagaLPG;
            @endphp

            <tr class="align-top">
                <td>
                    <b>Jenis Izin Usaha:</b> {{ $item->kode_izin_desc }}<br>
                    <b>Jenis Kegiatan Usaha:</b> {{ $item->nama_opsi ?? 'N/A' }}
                </td>
                <td>{{ $item->tanggal_pengesahan }}</td>
                <td>{{ $item->no_sk_izin }}</td>
                <td>
                    <ul class="sub-menu" aria-expanded="false">
                        {{-- Menu utama --}}
                        @if (!empty($item->url))
                            <li>
                                <a href="{{ url($item->url) }}/{{ $encodedShow }}">
                                    {{ $item->nama_menu }}
                                </a>
                            </li>
                        @endif

                        {{-- Pengolahan Minyak (kategori 2) --}}
                        @if ($isPengolahan && $kategori == 2)
                            <li><a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a></li>
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                            <li><a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a></li>
                        @endif

                        {{-- Niaga Minyak (kategori 2) --}}
                        @if ($isNiaga && $kategori == 2)
                            <li><a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a></li>
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                            <li><a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a></li>
                        @endif

                        {{-- Niaga LPG (kategori 1, ada harga) --}}
                        @if ($isNiagaLPG)
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                            <li><a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga LPG</a></li>
                        @endif

                        {{-- Niaga Gas lain (BBG, CNG, LNG) tanpa harga --}}
                        @if ($isNiagaGasTanpaHarga)
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                        @endif

                        {{-- Sementara Niaga --}}
                        @if ($isNiagaS && Session::get('j_niaga_s') > 0)
                            <li><a href="{{ url('/progres-pembangunan/show') }}/{{ $encodedShow }}">Progres Pembangunan</a></li>
                        @endif

                        {{-- Pengangkutan atau Pengolahan Gas --}}
                        @if ($isKusus && ($isPengangkutan || ($isPengolahan && Session::get('j_pengolahan') > 0)))
                            <li><a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $encodedShow }}">Penyimpanan Gas Bumi</a></li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
