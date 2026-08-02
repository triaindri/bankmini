<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        h2 { text-align: center; margin-bottom: 2px; }
        p.subtitle { text-align: center; margin-top: 0; color: #666; }
        h3 { margin-top: 24px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        td.right { text-align: right; }
        td.center { text-align: center; }
        .ringkasan { width: 100%; margin-top: 8px; }
        .ringkasan td { border: none; padding: 4px 8px; }
        .kategori-baik { color: #15803d; font-weight: bold; }
        .kategori-cukup { color: #a16207; font-weight: bold; }
        .kategori-kurang { color: #b91c1c; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Bank Mini</h2>
    <p class="subtitle">
        SMKS Pasundan 1 Cianjur — Periode {{ $awal->translatedFormat('d F Y') }} s/d {{ $akhir->translatedFormat('d F Y') }}
        <br>Dicetak pada {{ now()->translatedFormat('d F Y') }}
    </p>

    <h3>Rekap Kas</h3>
    <table class="ringkasan">
        <tr>
            <td>Total Setoran</td>
            <td class="right">Rp {{ number_format($rekapKas->total_setor ?? 0, 0, ',', '.') }} ({{ $rekapKas->jumlah_transaksi_setor ?? 0 }} transaksi)</td>
        </tr>
        <tr>
            <td>Total Penarikan</td>
            <td class="right">Rp {{ number_format($rekapKas->total_tarik ?? 0, 0, ',', '.') }} ({{ $rekapKas->jumlah_transaksi_tarik ?? 0 }} transaksi)</td>
        </tr>
        <tr>
            <td><strong>Selisih Kas</strong></td>
            <td class="right"><strong>Rp {{ number_format(($rekapKas->total_setor ?? 0) - ($rekapKas->total_tarik ?? 0), 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <h3>Data Siswa</h3>
    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Saldo</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $s)
                @php $analisis = $s->analisisPerilaku->first(); @endphp
                <tr>
                    <td>{{ $s->nis }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td class="right">Rp {{ number_format(optional($s->tabungan)->saldo ?? 0, 0, ',', '.') }}</td>
                    <td class="center">
                        @if ($analisis)
                            <span class="kategori-{{ strtolower($analisis->kategori) }}">{{ $analisis->kategori }}</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>