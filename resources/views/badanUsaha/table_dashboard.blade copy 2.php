<table class="kt-datatable table table-bordered table-hover">
    <thead class="bg-light">
        <tr class="fw-bold text-uppercase">
            <th> Izin</th>
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
                <td>{{ $item->no_sk_izin }} </td>
                <td>
                    @php
                        // Enkripsi parameter untuk URL
                        $encodedShow = Crypt::encryptString(
                            $item->id_permohonan . ',' .
                            $item->no_sk_izin . ',' .
                            $item->id_sub_page . ',' .
                            $item->kategori . ',' .
                            $item->id_izin
                        );
                        $encodedShow = urlencode($encodedShow);
                    @endphp

                    <ul class="sub-menu" aria-expanded="false">
                        {{-- URL Dinamis --}}
                        @if (!empty($item->url))
                            <li>
                                <a href="{{ $item->url }}/{{ $encodedShow }}">
                                    {{ $item->nama_menu }}
                                </a>
                            </li>
                        @endif

                        {{-- Kondisi Khusus --}}
                        @php
                            // Cek kondisi berdasarkan sub_page yang sudah diproses sebelumnya
                            $matchedSubPage = collect($sub_page)
                                ->whereIn('id_sub_page', collect($result)->pluck('sub_page_id'))
                                ->firstWhere('kategori', 2);

                            $matchedSubPage1 = collect($sub_page)
                                ->whereIn('id_sub_page', collect($result)->pluck('sub_page_id'))
                                ->firstWhere('kategori', 1);

                            $kusus = collect($sub_page)
                                ->whereIn('id_sub_page', collect($result)->pluck('sub_page_id'))
                                ->firstWhere('id_sub_menu', 1);
                        @endphp

                        {{-- Pengolahan --}}
                        @if (Session::get('j_pengolahan') > 0)
                            @if ($matchedSubPage)  {{-- Cek berdasarkan matchedSubPage untuk kategori 2 --}}
                                <li>
                                    <a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a>
                                </li>
                                <li>
                                    <a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a>
                                </li>
                                <li>
                                    <a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a>
                                </li>
                            @endif
                            @if ($kusus) {{-- Cek berdasarkan kondisi khusus, jika ada --}}
                                <li>
                                    <a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $encodedShow }}">Penyimpanan Gas Bumi</a>
                                </li>
                            @endif
                        @endif

                        {{-- Niaga --}}
                        @if (Session::get('j_niaga') > 0)
                            @if ($matchedSubPage1)  {{-- Cek berdasarkan matchedSubPage1 untuk kategori 1 --}}
                                <li>
                                    <a href="{{ url('/penyimpananMinyakBumi') }}/{{ $encodedShow }}">Penyimpanan Minyak Bumi</a>
                                </li>
                                <li>
                                    <a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a>
                                </li>
                                <li>
                                    <a href="{{ url('/harga-bbm-jbu') }}/{{ $encodedShow }}">Harga BBM JBU</a>
                                </li>
                            @endif
                            @if ($matchedSubPage)  {{-- Cek berdasarkan matchedSubPage untuk kategori 2 --}}
                                <li>
                                    <a href="{{ url('/eksport-import') }}/{{ $encodedShow }}">Ekspor-Impor</a>
                                </li>
                            @endif
                        @endif

                        {{-- Pengangkutan --}}
                        @if (Session::get('j_pengangkutan') > 0 && $kusus)  {{-- Cek berdasarkan kondisi khusus --}}
                            <li>
                                <a href="{{ url('/penyimpanan-gas-bumi') }}/{{ $encodedShow }}">Penyimpanan Gas Bumi</a>
                            </li>
                        @endif

                        {{-- Niaga S --}}
                        @if (Session::get('j_niaga_s') > 0)
                            <li>
                                <a href="{{ url('/progres-pembangunan/show') }}/{{ $encodedShow }}">Progres Pembangunan</a>
                            </li>
                        @endif
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
