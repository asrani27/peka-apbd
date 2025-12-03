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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="triwulan_filter">
                                                    <i class="fas fa-chart-pie"></i> Triwulan
                                                </label>
                                                <select class="form-control" id="triwulan_filter" name="triwulan">
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
                                                <label for="tahun_filter">
                                                    <i class="fas fa-calendar"></i> Tahun
                                                </label>
                                                <select class="form-control" id="tahun_filter" name="tahun">
                                                    <option value="">Semua Tahun</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025">2025</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="d-block">
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="applyFilters()">
                                                        <i class="fas fa-search"></i> Terapkan
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm ml-1"
                                                        onclick="resetFilters()">
                                                        <i class="fas fa-redo"></i> Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="mt-3 table-responsive">
                    <table class="table table-hover text-nowrap table-sm table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">No</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">Kode</th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center">Nama</th>
                                <th colspan="5" style="vertical-align: middle; text-align:center">Nilai Capaian</th>
                                <th colspan="2" style="vertical-align: middle; text-align:center">Periode</th>
                            </tr>
                            <tr class="bg-primary">
                                <th style="vertical-align: middle; text-align:center">Revisi DPA</th>
                                <th style="vertical-align: middle; text-align:center">Deviasi DPA</th>
                                <th style="vertical-align: middle; text-align:center">Penyerapan Anggaran</th>
                                <th style="vertical-align: middle; text-align:center">Capaian Output</th>
                                <th style="vertical-align: middle; text-align:center">Total Nilai Capaian</th>
                                <th style="vertical-align: middle; text-align:center">Semester</th>
                                <th style="vertical-align: middle; text-align:center">Triwulan</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($skpd as $key => $item)

                            @php
                            $ikpaData = $item->ikpa->first(); // Get first IKPA record for this SKPD
                            $deviasiData = $item->deviasi->first(); // Get first Deviasi record for this SKPD

                            // Convert month number to month name
                            $monthNames = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            $bulanNama = $monthNames[$bulan] ?? $bulan;
                            @endphp
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama}}</td>
                                <td style="text-align: center">
                                    {{-- {{dd($ikpaData, $ikpaData->semester)}} --}}
                                    @if($ikpaData && $ikpaData->semester)
                                    {{$ikpaData->skorRevisiTertimbang($ikpaData->semester)}}
                                    @else
                                    {{110 * 0.15}}
                                    @endif
                                </td>
                                <td style="text-align: center">

                                    @if($deviasiData && $tahun && $bulan)
                                    {{$deviasiData->skorDeviasiTertimbang($tahun, $bulan)}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    @if($deviasiData && $tahun && $bulan)
                                    {{$deviasiData->skorPenyerapanTertimbang($tahun, $bulan)}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    @if($ikpaData && $tahun && $bulan)
                                    {{-- Placeholder for Capaian Output score --}}
                                    0
                                    @else
                                    0
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    {{-- Calculate Total Nilai Capaian --}}
                                    @if($ikpaData && $semester && $tahun && $bulan)
                                    {{($ikpaData->skorRevisiTertimbang($semester) +
                                    $ikpaData->skorDeviasiTertimbang($tahun, $bulan) +
                                    $ikpaData->skorPenyerapanTertimbang($tahun, $bulan) + 0)}}
                                    @else
                                    0
                                    @endif
                                </td>
                                <td style="text-align: center">
                                    {{$semester ?? '-'}}
                                </td>
                                <td style="text-align: center">
                                    @if($bulanNama)
                                    {{ $tahun ? $bulanNama . ' ' . $tahun : $bulanNama }}
                                    @else
                                    {{ $triwulan ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function applyFilters() {
    const triwulan = document.getElementById('triwulan_filter').value;
    const tahun = document.getElementById('tahun_filter').value;
    
    // Build URL with query parameters
    let url = new URL(window.location.href);
    
    // Add or update parameters
    if (triwulan) {
        url.searchParams.set('triwulan', triwulan);
    } else {
        url.searchParams.delete('triwulan');
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
    document.getElementById('triwulan_filter').value = '';
    document.getElementById('tahun_filter').value = '';
    
    // Clear all query parameters and reload
    let url = new URL(window.location.href);
    url.searchParams.delete('semester');
    url.searchParams.delete('triwulan');
    url.searchParams.delete('tahun');
    
    window.location.href = url.toString();
}

// Set filter values from URL parameters on page load
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    const triwulan = urlParams.get('triwulan');
    const tahun = urlParams.get('tahun');
    
    if (triwulan) {
        document.getElementById('triwulan_filter').value = triwulan;
    }
    
    if (tahun) {
        document.getElementById('tahun_filter').value = tahun;
    }
});
</script>
@endpush