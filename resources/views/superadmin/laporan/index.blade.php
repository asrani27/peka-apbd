@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <img src="/logo/bpkpad.png" width="15%">
        <h2>LAPORAN PEKA APBD KOTA BANJARMASIN</h2>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> Filter Laporan
                </h3>
            </div>
            <div class="card-body">
                <form method="post" id="laporanForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="semester">
                                    <i class="fas fa-calendar-alt"></i> Semester
                                </label>
                                <select class="form-control" name="semester" id="semester" required>
                                    <option value="">- Pilih Semester -</option>
                                    <option value="1" {{($semester ?? old('semester'))=='1' ? 'selected' : '' }}>
                                        Semester 1</option>
                                    <option value="2" {{($semester ?? old('semester'))=='2' ? 'selected' : '' }}>
                                        Semester 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tahun">
                                    <i class="fas fa-calendar"></i> Tahun
                                </label>
                                <select class="form-control" name="tahun" id="tahun" required>
                                    <option value="">- Pilih Tahun -</option>
                                    <option value="2024" {{($tahun ?? old('tahun'))=='2024' ? 'selected' : '' }}>2024
                                    </option>
                                    <option value="2025" {{($tahun ?? old('tahun'))=='2025' ? 'selected' : '' }}>2025
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="skpd_id">
                                    <i class="fas fa-building"></i> Nama SKPD
                                </label>
                                <select class="form-control" name="skpd_id" id="skpd_id">
                                    <option value="">- Semua SKPD -</option>
                                    @if(isset($skpdList))
                                    @foreach($skpdList as $skpd)
                                    <option value="{{ $skpd->id }}" {{($skpd_id ?? old('skpd_id'))==$skpd->id ?
                                        'selected' : '' }}>
                                        {{ $skpd->nama ?: $skpd->nama }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="d-block">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> TAMPILKAN
                                    </button>
                                    <button type="button" class="btn btn-success ml-1" onclick="exportToExcel()">
                                        <i class="fas fa-file-excel"></i> EXPORT EXCEL
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($rfkData) && $rfkData && $skpd_id)
    <!-- RFK Data Table (API Data) -->
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-body">
                <table width="100%" cellpadding="5">
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold"
                            width="10%">SKPD</td>
                        <td style="border: 1px solid black;">: {{ $laporanData[0]['skpd']->nama }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold">TAHUN</td>
                        <td style="border: 1px solid black;">: {{ $tahun }}</td>
                    </tr>
                </table>
                <br />

                <h2>Data RAK dari API Kenangan</h2>
                <div class="table-responsive">
                    <table width="100%" cellpadding="5">
                        <tr class="bg-warning" style="font-size:14px;font-weight:bold;text-align:center">
                            <td rowspan="2" style="border:1px solid black">NO</td>
                            <td rowspan="2" style="border:1px solid black; min-width:110px;">BULAN</td>
                            <td colspan="4" style="border:1px solid black">RAK Tahunan</td>
                            <td colspan="4" style="border:1px solid black">Realisasi RAK</td>
                        </tr>
                        <tr class="bg-warning" style="font-size:12px;font-weight:bold;text-align:center">
                            <td style="border:1px solid black; min-width:110px;">5.1</td>
                            <td style="border:1px solid black; min-width:110px;">5.2</td>
                            <td style="border:1px solid black; min-width:110px;">5.3</td>
                            <td style="border:1px solid black; min-width:110px;">5.4</td>
                            <td style="border:1px solid black; min-width:110px;">5.1</td>
                            <td style="border:1px solid black; min-width:110px;">5.2</td>
                            <td style="border:1px solid black; min-width:110px;">5.3</td>
                            <td style="border:1px solid black; min-width:110px;">5.4</td>
                        </tr>
                        @php
                        $monthNames = [
                        'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                        'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
                        ];

                        $monthDisplay = [
                        'januari' => 'Januari', 'februari' => 'Februari', 'maret' => 'Maret',
                        'april' => 'April', 'mei' => 'Mei', 'juni' => 'Juni',
                        'juli' => 'Juli', 'agustus' => 'Agustus', 'september' => 'September',
                        'oktober' => 'Oktober', 'november' => 'November', 'desember' => 'Desember'
                        ];

                        $filteredMonths = $semester == 1 ?
                        array_slice($monthNames, 0, 6) :
                        array_slice($monthNames, 6, 6);

                        $no = 1;
                        $total_rak_51 = 0;
                        $total_rak_52 = 0;
                        $total_rak_53 = 0;
                        $total_rak_54 = 0;
                        $total_real_51 = 0;
                        $total_real_52 = 0;
                        $total_real_53 = 0;
                        $total_real_54 = 0;
                        @endphp

                        @foreach($filteredMonths as $month)
                        @if(isset($rfkData[$month]))
                        @php
                        $monthData = $rfkData[$month];
                        $rak_51 = $monthData['rencana']['5.1'] ?? 0;
                        $rak_52 = $monthData['rencana']['5.2'] ?? 0;
                        $rak_53 = $monthData['rencana']['5.3'] ?? 0;
                        $rak_54 = $monthData['rencana']['5.4'] ?? 0;
                        $real_51 = $monthData['realisasi']['5.1'] ?? 0;
                        $real_52 = $monthData['realisasi']['5.2'] ?? 0;
                        $real_53 = $monthData['realisasi']['5.3'] ?? 0;
                        $real_54 = $monthData['realisasi']['5.4'] ?? 0;

                        $total_rak_51 += $rak_51;
                        $total_rak_52 += $rak_52;
                        $total_rak_53 += $rak_53;
                        $total_rak_54 += $rak_54;
                        $total_real_51 += $real_51;
                        $total_real_52 += $real_52;
                        $total_real_53 += $real_53;
                        $total_real_54 += $real_54;
                        @endphp

                        <tr style="font-size:10px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                            <td style=" border:1px solid black">{{ $no }}</td>
                            <td style=" border:1px solid black">{{ $monthDisplay[$month] }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($rak_51, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($rak_52, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($rak_53, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($rak_54, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($real_51, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($real_52, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($real_53, 0, ',', '.') }}</td>
                            <td style=" border:1px solid black;text-align:right">
                                {{ number_format($real_54, 0, ',', '.') }}</td>
                        </tr>
                        @php $no++; @endphp
                        @endif
                        @endforeach

                        <tr
                            style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;">
                            <td style=" border:1px solid black" colspan="2">JUMLAH</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_rak_51, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_rak_52, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_rak_53, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_rak_54, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_real_51, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_real_52, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_real_53, 0, ',', '.') }}</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_real_54, 0, ',', '.') }}</td>
                        </tr>

                        <tr
                            style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;">
                            <td style=" border:1px solid black" colspan="2">TOTAL PAGU</td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54, 0, ',',
                                '.') }}</td>
                            <td style="border:1px solid black;text-align:right" colspan="7"></td>
                        </tr>

                        @if(($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54) > 0)
                        <tr
                            style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;">
                            <td style=" border:1px solid black" colspan="2">*Proporsi pagu berdasarkan kelompok belanja
                            </td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format(($total_rak_51 / ($total_rak_51 + $total_rak_52 + $total_rak_53 +
                                $total_rak_54)) * 100, 2) }} %
                            </td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format(($total_rak_52 / ($total_rak_51 + $total_rak_52 + $total_rak_53 +
                                $total_rak_54)) * 100, 2) }} %
                            </td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format(($total_rak_53 / ($total_rak_51 + $total_rak_52 + $total_rak_53 +
                                $total_rak_54)) * 100, 2) }} %
                            </td>
                            <td style="border:1px solid black;text-align:right">
                                {{ number_format(($total_rak_54 / ($total_rak_51 + $total_rak_52 + $total_rak_53 +
                                $total_rak_54)) * 100, 2) }} %
                            </td>
                            <td style="border:1px solid black;text-align:right" colspan="5"></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    @elseif(isset($laporanData) && count($laporanData) > 0)
    <!-- Laporan Table -->
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table"></i> Hasil Laporan
                    <small class="text-muted">
                        Semester {{ $semester }} - Tahun {{ $tahun }}
                        @if($skpd_id)
                        - SKPD: {{ $laporanData[0]['skpd']->singkatan ?: $laporanData[0]['skpd']->nama }}
                        @endif
                    </small>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Kode SKPD</th>
                                <th style="width: 25%">Nama SKPD</th>
                                <th style="width: 15%">Revisi DPA</th>
                                <th style="width: 15%">Deviasi DPA</th>
                                <th style="width: 10%">Penyerapan</th>
                                <th style="width: 10%">Capaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporanData as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['skpd']->kode }}</td>
                                <td>{{ $item['skpd']->singkatan ?: $item['skpd']->nama }}</td>
                                <td class="text-center">
                                    @if(isset($item['data']['skor_it']))
                                    <span
                                        class="badge badge-{{ $item['data']['skor_it'] >= 80 ? 'success' : ($item['data']['skor_it'] >= 60 ? 'warning' : 'danger') }}">
                                        {{ $item['data']['skor_it'] }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($item['data']['avg_deviasi']))
                                    <span
                                        class="badge badge-{{ $item['data']['avg_deviasi'] >= 80 ? 'success' : ($item['data']['avg_deviasi'] >= 60 ? 'warning' : 'danger') }}">
                                        {{ $item['data']['avg_deviasi'] }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($item['data']['avg_penyerapan']))
                                    <span
                                        class="badge badge-{{ $item['data']['avg_penyerapan'] >= 80 ? 'success' : ($item['data']['avg_penyerapan'] >= 60 ? 'warning' : 'danger') }}">
                                        {{ $item['data']['avg_penyerapan'] }}%
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(isset($item['data']['avg_capaian']))
                                    <span
                                        class="badge badge-{{ $item['data']['avg_capaian'] >= 80 ? 'success' : ($item['data']['avg_capaian'] >= 60 ? 'warning' : 'danger') }}">
                                        {{ $item['data']['avg_capaian'] }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Card -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-file"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total SKPD</span>
                                <span class="info-box-number">{{ count($laporanData) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">SKPD Lengkap</span>
                                <span class="info-box-number">
                                    {{ collect($laporanData)->filter(function($item) { return
                                    isset($item['data']['skor_it']) && isset($item['data']['avg_deviasi']) &&
                                    isset($item['data']['avg_penyerapan']) && isset($item['data']['avg_capaian']);
                                    })->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i="fas fa-exclamation-triangle"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Data Tidak Lengkap</span>
                                <span class="info-box-number">
                                    {{ collect($laporanData)->filter(function($item) { return
                                    !isset($item['data']['skor_it']) || !isset($item['data']['avg_deviasi']) ||
                                    !isset($item['data']['avg_penyerapan']) || !isset($item['data']['avg_capaian']);
                                    })->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Belum Ada Data</span>
                                <span class="info-box-number">
                                    {{ collect($laporanData)->filter(function($item) { return empty($item['data']);
                                    })->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('js')
<script>
    // Function to reset form
    function resetForm() {
        document.getElementById('laporanForm').reset();
    }
    
    // Function to export to Excel
    function exportToExcel() {
        @if(isset($semester) && isset($tahun) && isset($skpd_id) && $skpd_id)
            var exportUrl = '{{ route("superadmin.laporan.export") }}?' +
                          'semester={{ $semester }}' +
                          '&tahun={{ $tahun }}' +
                          '&skpd_id={{ $skpd_id }}';
            window.open(exportUrl, '_blank');
        @else
            alert('Silakan pilih Semester, Tahun, dan SKPD terlebih dahulu untuk export Excel');
        @endif
    }
    
    // Function to export to PDF (placeholder)
    function exportToPDF() {
        alert('Export PDF akan segera tersedia');
    }
</script>
@endpush
