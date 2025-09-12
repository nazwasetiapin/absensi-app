<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $namaBulan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; word-wrap: break-word; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Rekap Absensi - {{ $namaBulan }}</h2>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            @foreach ($tanggalList as $tanggal)
                <th>{{ \Carbon\Carbon::parse($tanggal)->format('d') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rekap as $nama => $kehadiran)
            <tr>
                <td>{{ $nama }}</td>
                @foreach ($tanggalList as $tanggal)
                    <td style="color:
                        {{ $kehadiran[$tanggal] === 'Hadir' ? 'green' :
                           ($kehadiran[$tanggal] === 'Izin' ? 'orange' :
                           ($kehadiran[$tanggal] === 'Cuti' ? 'orange' : 'red')) }}">
                        {{ $kehadiran[$tanggal] ?? '-' }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
