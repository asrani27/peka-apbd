<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian SKPD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 14px;
        }

        .filter-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }

        .filter-info p {
            margin: 5px 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
        }

        td {
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .no {
            text-align: center;
            width: 30px;
        }

        .kode {
            text-align: center;
            width: 80px;
        }

        .nama {
            width: 200px;
        }

        .nilai {
            text-align: center;
            width: 100px;
        }

        .keterangan {
            text-align: center;
            width: 100px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }

        @page {
            margin: 20mm;
            orientation: landscape;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN PENILAIAN SKPD</h2>
        <h3>SISTEM EVALUASI PENYERAPAN ANGGARAN DAN KINERJA (SIPEKA)</h3>
    </div>

    @php
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $bulanNama = $monthNames[$bulan] ?? $bulan;
    @endphp
    
    <div class="filter-info">
        <p><strong>Filter:</strong></p>
        @if($semester)
        <p>Semester: {{ $semester }}</p>
        @endif
        @if($triwulan)
        <p>Triwulan: {{ $triwulan }}</p>
        @endif
        @if($bulan)
        <p>Bulan: {{ $bulanNama }}</p>
        @endif
        @if($tahun)
        <p>Tahun: {{ $tahun }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="no">No</th>
                <th rowspan="2" class="nama">Nama</th>
                <th colspan="5">Nilai Capaian</th>
                <th rowspan="2" class="keterangan">Keterangan</th>
            </tr>
            <tr>
                <th class="nilai">Revisi DPA</th>
                <th class="nilai">Deviasi DPA</th>
                <th class="nilai">Penyerapan Anggaran</th>
                <th class="nilai">Capaian Output</th>
                <th class="nilai">Total Nilai Capaian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($skpd as $key => $item)
            @php
            // Pre-compute common values to avoid repeated calculations
            $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $bulanNama = $monthNames[$bulan] ?? $bulan;
            $currentSemester = $semester ?? 1;

            // Get data once per row
            $deviasiData = $item->deviasi->first();
            $revisiData = $item->revisi->first();
            $capaianData = $item->capaian->first();

            // Pre-calculate Revisi DPA value
            $revisiDpaValue = '';
            if ($revisiData) {
            $revisiDpaValue = ($currentSemester == 1)
            ? number_format($revisiData->skorITSemester1(), 2, ',', '.')
            : number_format($revisiData->skorITSemester2(), 2, ',', '.');
            }

            // Pre-calculate Deviasi DPA and Penyerapan Anggaran values
            $deviasiDpaValue = '';
            $penyerapanAnggaranValue = '';
            if ($deviasiData && isset($deviasiCumulativeData[$item->id])) {
            $cumulativeData = $deviasiCumulativeData[$item->id]['cumulativeData'];
            $details = $deviasiCumulativeData[$item->id]['details'];

            // Find the detail record for the selected month
            $selectedDetail = $bulan
            ? $details->where('bulan', $bulanNama)->first()
            : $details->last();

            if ($selectedDetail && isset($cumulativeData[$selectedDetail->id])) {
            $nilaiIkpa = $cumulativeData[$selectedDetail->id]['nilai_ikpa'];
            $penyerapanAnggaran = $cumulativeData[$selectedDetail->id]['penyerapan_anggaran'];

            $deviasiDpaValue = number_format($nilaiIkpa * 0.2, 2, ',', '.');
            $penyerapanAnggaranValue = number_format($penyerapanAnggaran * 0.3, 2, ',', '.');
            }
            }

            // Pre-calculate Capaian Output value
            $capaianOutputValue = '';
            if ($capaianData && $triwulan) {
            $capaianOutputValue =
            $capaianData->getFormattedSkorIndikatorTertimbangDenganBobot($triwulan);
            }

            // Calculate total using automatic mutators and format for display
            $totalDecimal = getDecimalValue($revisiDpaValue) +
            getDecimalValue($deviasiDpaValue) +
            getDecimalValue($penyerapanAnggaranValue) +
            $capaianOutputValue;
            $totalFormatted = formatIndonesianNumber($totalDecimal);
            $keterangan = getPerformanceRating($totalDecimal);
            @endphp
            <tr>
                <td class="no">{{ $key + 1 }}</td>
                <td class="nama">{{ $item->nama }}</td>
                <td class="nilai">{{ $revisiDpaValue }}</td>
                <td class="nilai">{{ $deviasiDpaValue }}</td>
                <td class="nilai">{{ $penyerapanAnggaranValue }}</td>
                <td class="nilai">{{ $capaianOutputValue }}</td>
                <td class="nilai">{{ $totalFormatted }}</td>
                <td class="keterangan">{{ $keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>Sistem Evaluasi Penyerapan Anggaran dan Kinerja (SIPEKA)</p>
    </div>
</body>

</html>
