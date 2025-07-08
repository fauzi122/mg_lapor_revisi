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
            <tr class="align-top">
                <td>
                    <b>Jenis Izin Usaha:</b> {{ $item->kode_izin_desc }}
                    <br>
                    <b>Jenis Kegiatan Usaha:</b> {{ $item->nama_opsi ?? 'N/A' }}
                </td>
                <td>{{ $item->tanggal_pengesahan }}</td>
                <td>{{ $item->no_sk_izin }}</td>
                <td>
                    @php
                        $encodedShow = Crypt::encryptString(implode(',', [
                            $item->id_permohonan ?? '',
                            $item->no_sk_izin ?? '',
                            $item->id_sub_page ?? '',
                            $item->kategori ?? '',
                            $item->id_izin ?? '',
                        ]));
                        $encodedShow = urlencode($encodedShow);

                        $currentSubPage = collect($sub_page)->firstWhere('id_sub_page', $item->id_sub_page);
                        $kategori = $currentSubPage->kategori ?? null;

                        $isNiaga         = str_contains(strtolower($item->kode_izin_desc), 'niaga');
                        $isNiagaS        = str_contains(strtolower($item->kode_izin_desc), 'sementara niaga');
                        $isPengolahan    = str_contains(strtolower($item->kode_izin_desc), 'pengolahan');
                        $isPengangkutan  = str_contains(strtolower($item->kode_izin_desc), 'pengangkutan');
                        $isKusus         = $currentSubPage && $currentSubPage->id_sub_menu == 1;
                    @endphp

                    <ul class="sub-menu" aria-expanded="false">
                        {{-- Menu utama --}}
                        @if (!empty($item->url))
                            <li>
                            <a href="{{ url($item->url) }}/{{ $encodedShow }}">
                                {{ $item->nama_menu }}
                            </a>

                            </li>
                        @endif

                        {{-- Menu untuk kategori 2 (pengolahan minyak) --}}
                        @if ($isPengolahan && $kategori == 2)
                            <li><a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a></li>
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                            <li><a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a></li>
                        @endif

                        {{-- Menu untuk kategori 1 (niaga) --}}
                        @if ($isNiaga && $kategori == 1)
                            <li><a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a></li>
                            <li><a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a></li>
                            <li><a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a></li>
                        @endif

                        {{-- Menu untuk sementara niaga --}}
                        @if ($isNiagaS && Session::get('j_niaga_s') > 0)
                            <li><a href="{{ url('/progres-pembangunan/show') }}/{{ $encodedShow }}">Progres Pembangunan</a></li>
                        @endif

                        {{-- Menu khusus untuk pengangkutan atau pengolahan gas --}}
                        @if ($isKusus && ($isPengangkutan || ($isPengolahan && Session::get('j_pengolahan') > 0)))
                            <li><a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $encodedShow }}">Penyimpanan Gas Bumi</a></li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>