@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data SKPD.</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Filter Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-filter"></i> Filter Data
                                </h3>
                            </div>
                            <div class="card-body">
                                <form id="filterForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="semester_filter">
                                                    <i class="fas fa-calendar-alt"></i> Semester
                                                </label>
                                                <select class="form-control" id="semester_filter" name="semester"
                                                    onchange="updateTriwulanOptions()">
                                                    <option value="">Semua Semester</option>
                                                    <option value="1">Semester 1</option>
                                                    <option value="2">Semester 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="triwulan_filter">
                                                    <i class="fas fa-chart-pie"></i> Triwulan
                                                </label>
                                                <select class="form-control" id="triwulan_filter" name="triwulan"
                                                    onchange="updateBulanOptions()">
                                                    <option value="">Semua Triwulan</option>
                                                    <option value="1">Triwulan 1</option>
                                                    <option value="2">Triwulan 2</option>
                                                    <option value="3">Triwulan 3</option>
                                                    <option value="4">Triwulan 4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="bulan_filter">
                                                    <i class="fas fa-calendar"></i> Nama Bulan
                                                </label>
                                                <select class="form-control" id="bulan_filter" name="bulan">
                                                    <option value="">Semua Bulan</option>
                                                    <option value="1">Januari</option>
                                                    <option value="2">Februari</option>
                                                    <option value="3">Maret</option>
                                                    <option value="4">April</option>
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                                    <option value="8">Agustus</option>
                                                    <option value="9">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tahun_filter">
                                                    <i class="fas fa-calendar"></i> Tahun
                                                </label>
                                                <select class="form-control" id="tahun_filter" name="tahun">
                                                    <option value="">Semua Tahun</option>
                                                    <option value="2025">2025</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary btn-sm" id="applyBtn"
                                                    onclick="applyFilters()">
                                                    <i class="fas fa-search"></i> <span id="btnText">Terapkan</span>
                                                </button>
                                                <button type="button" class="btn btn-default btn-sm ml-1"
                                                    onclick="resetFilters()">
                                                    <i class="fas fa-redo"></i> Reset
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                @if($semester || $triwulan || $tahun || $bulan)
                <div class="mt-3 table-responsive">
                    <table class="table table-hover text-nowrap table-sm table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">No</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">Kode</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">Nama</th>
                                <th colspan="5" style="vertical-align: middle; text-align:center">Nilai Capaian</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">Keterangan</th>
                            </tr>
                            <tr class="bg-primary">
                                <th style="vertical-align: middle; text-align:center">Revisi DPA</th>
                                <th style="vertical-align: middle; text-align:center">Deviasi DPA</th>
                                <th style="vertical-align: middle; text-align:center">Penyerapan Anggaran</th>
                                <th style="vertical-align: middle; text-align:center">Capaian Output</th>
                                <th style="vertical-align: middle; text-align:center">Total Nilai Capaian</th>
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
                                <td>{{$key + 1}}</td>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$revisiDpaValue}}</td>
                                <td>{{$deviasiDpaValue}}</td>
                                <td>{{$penyerapanAnggaranValue}}</td>
                                <td>{{$capaianOutputValue}}</td>
                                <td>{{$totalFormatted}}</td>
                                <td>{{$keterangan}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                @else
                <div class="mt-3 alert alert-info">
                    <i class="fas fa-info-circle"></i> Silakan pilih filter dan klik tombol "Terapkan" untuk menampilkan
                    data.
                </div>
                @endif
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function updateTriwulanOptions() {
        const semester = document.getElementById('semester_filter').value;
        const triwulanSelect = document.getElementById('triwulan_filter');
        const bulanSelect = document.getElementById('bulan_filter');
        
        // Reset bulan filter when semester changes
        bulanSelect.value = '';
        
        if (semester === '1') {
            // Show only Triwulan 1 and 2 for Semester 1
            triwulanSelect.innerHTML = `
                <option value="">Semua Triwulan</option>
                <option value="1">Triwulan 1</option>
                <option value="2">Triwulan 2</option>
            `;
        } else if (semester === '2') {
            // Show only Triwulan 3 and 4 for Semester 2
            triwulanSelect.innerHTML = `
                <option value="">Semua Triwulan</option>
                <option value="3">Triwulan 3</option>
                <option value="4">Triwulan 4</option>
            `;
        } else {
            // Show all triwulan when no semester selected
            triwulanSelect.innerHTML = `
                <option value="">Semua Triwulan</option>
                <option value="1">Triwulan 1</option>
                <option value="2">Triwulan 2</option>
                <option value="3">Triwulan 3</option>
                <option value="4">Triwulan 4</option>
            `;
        }
    }
    
    function updateBulanOptions() {
        const triwulan = document.getElementById('triwulan_filter').value;
        const bulanSelect = document.getElementById('bulan_filter');
        
        if (triwulan === '1') {
            // Show Januari, Februari, Maret for Triwulan 1
            bulanSelect.innerHTML = `
                <option value="">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
            `;
        } else if (triwulan === '2') {
            // Show April, Mei, Juni for Triwulan 2
            bulanSelect.innerHTML = `
                <option value="">Semua Bulan</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
            `;
        } else if (triwulan === '3') {
            // Show Juli, Agustus, September for Triwulan 3
            bulanSelect.innerHTML = `
                <option value="">Semua Bulan</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
            `;
        } else if (triwulan === '4') {
            // Show Oktober, November, Desember for Triwulan 4
            bulanSelect.innerHTML = `
                <option value="">Semua Bulan</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            `;
        } else {
            // Show all months when no triwulan selected
            bulanSelect.innerHTML = `
                <option value="">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            `;
        }
    }

    function applyFilters() {
        const semester = document.getElementById('semester_filter').value;
        const triwulan = document.getElementById('triwulan_filter').value;
        const bulan = document.getElementById('bulan_filter').value;
        const tahun = document.getElementById('tahun_filter').value;
        
        // Show loading state
        const applyBtn = document.getElementById('applyBtn');
        const btnText = document.getElementById('btnText');
        applyBtn.disabled = true;
        btnText.textContent = 'Memuat...';
        applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span id="btnText">Memuat...</span>';
        
        // Build URL with query parameters
        let url = new URL(window.location.href);
        
        // Add or update parameters
        if (semester) {
            url.searchParams.set('semester', semester);
        } else {
            url.searchParams.delete('semester');
        }
        
        if (triwulan) {
            url.searchParams.set('triwulan', triwulan);
        } else {
            url.searchParams.delete('triwulan');
        }
        
        if (bulan) {
            url.searchParams.set('bulan', bulan);
        } else {
            url.searchParams.delete('bulan');
        }
        
        if (tahun) {
            url.searchParams.set('tahun', tahun);
        } else {
            url.searchParams.delete('tahun');
        }
        
        // Redirect to filtered URL
        window.location.href = url.toString();
    }

    function resetFilters() {
        // Reset all select elements
        document.getElementById('semester_filter').value = '';
        document.getElementById('triwulan_filter').value = '';
        document.getElementById('bulan_filter').value = '';
        document.getElementById('tahun_filter').value = '';
        
        // Reset triwulan and bulan options to default
        updateTriwulanOptions();
        updateBulanOptions();
        
        // Clear all query parameters and reload
        let url = new URL(window.location.href);
        url.searchParams.delete('semester');
        url.searchParams.delete('triwulan');
        url.searchParams.delete('bulan');
        url.searchParams.delete('tahun');
        
        window.location.href = url.toString();
    }

    // Set filter values from URL parameters on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        const semester = urlParams.get('semester');
        const triwulan = urlParams.get('triwulan');
        const bulan = urlParams.get('bulan');
        const tahun = urlParams.get('tahun');
        
        // Set semester first, then triwulan, then bulan to maintain proper filtering
        if (semester) {
            document.getElementById('semester_filter').value = semester;
            updateTriwulanOptions();
        }
        
        if (triwulan) {
            document.getElementById('triwulan_filter').value = triwulan;
            updateBulanOptions();
        }
        
        if (bulan) {
            document.getElementById('bulan_filter').value = bulan;
        }
        
        if (tahun) {
            document.getElementById('tahun_filter').value = tahun;
        }
    });
</script>
@endpush