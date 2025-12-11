<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Grafik {{ strtoupper($penilaian) }}</title>
    <style>
        @page {
            margin: 1cm;
            orientation: landscape;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .subtitle {
            font-size: 14px;
            margin: 5px 0;
        }
        
        .filter-info {
            margin: 15px 0;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .filter-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        
        .filter-item {
            flex: 1;
            padding: 0 10px;
        }
        
        .chart-container {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .bar-chart {
            display: flex;
            align-items: flex-end;
            height: 300px;
            margin: 20px 0;
            padding: 0 20px;
            border-left: 2px solid #333;
            border-bottom: 2px solid #333;
            position: relative;
        }
        
        .bar {
            flex: 1;
            background-color: #28a745;
            margin: 0 5px;
            position: relative;
            min-height: 5px;
            max-width: 60px;
        }
        
        .bar-label {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            font-weight: bold;
            white-space: nowrap;
        }
        
        .bar-value {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 9px;
            white-space: nowrap;
        }
        
        .bar-name {
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%) rotate(-45deg);
            transform-origin: left center;
            font-size: 8px;
            white-space: nowrap;
            max-width: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo/bpkpad.png') }}" alt="Logo BPKPAD" class="logo">
        <div class="title">PEKA APBD KOTA BANJARMASIN</div>
        <div class="title">{{ $chartTitle }}</div>
        <div class="subtitle">Laporan Grafik Penilaian SKPD</div>
    </div>

    <div class="filter-info">
        <div class="filter-row">
            <div class="filter-item"><strong>Jenis Penilaian:</strong> {{ strtoupper($penilaian) }}</div>
            <div class="filter-item"><strong>Tahun:</strong> {{ $tahun }}</div>
            @if($semester)
            <div class="filter-item"><strong>Semester:</strong> {{ $semester }}</div>
            @endif
        </div>
        @if($triwulan)
        <div class="filter-row">
            <div class="filter-item"><strong>Triwulan:</strong> {{ $triwulan }}</div>
        </div>
        @endif
        @if($bulan)
        <div class="filter-row">
            <div class="filter-item"><strong>Bulan:</strong> 
                @php
                    $monthNames = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                    echo $monthNames[$bulan] ?? $bulan;
                @endphp
            </div>
        </div>
        @endif
    </div>

    <div class="chart-container">
        @if(count($skpd) > 0)
            @php
                $maxValue = max(array_column($skpd, 'y'));
                $scaleFactor = $maxValue > 0 ? 280 / $maxValue : 1;
            @endphp
            
            <div class="bar-chart">
                @foreach($skpd as $item)
                    @if($item['y'] > 0)
                        <div class="bar" style="height: {{ $item['y'] * $scaleFactor }}px;">
                            <div class="bar-label">{{ number_format($item['y'], 2) }}</div>
                            <div class="bar-value">{{ number_format($item['y'], 2) }}</div>
                            <div class="bar-name">{{ Str::limit($item['label'], 15) }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="no-data">Tidak ada data untuk ditampilkan</div>
        @endif
    </div>

    @if(count($skpd) > 0)
    <div class="data-section">
        <h3 style="text-align: center; margin: 20px 0;">Detail Data</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>SKPD</th>
                    <th>Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skpd as $key => $item)
                    @if($item['y'] > 0)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item['label'] }}</td>
                        <td>{{ number_format($item['y'], 2) }}</td>
                        <td>
                            @php
                                if ($item['y'] >= 80) {
                                    echo 'Sangat Baik';
                                } elseif ($item['y'] >= 60) {
                                    echo 'Baik';
                                } elseif ($item['y'] >= 40) {
                                    echo 'Cukup';
                                } elseif ($item['y'] >= 20) {
                                    echo 'Kurang';
                                } else {
                                    echo 'Sangat Kurang';
                                }
                            @endphp
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Sistem PEKA APBD</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
