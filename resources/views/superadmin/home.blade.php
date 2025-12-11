@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <img src="/logo/bpkpad.png" width="15%">
        <h2>PEKA ABPD KOTA BANJARMASIN</h2>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i> Filter Grafik
                </h3>
            </div>
            <div class="card-body">
                <form method="post" id="chartForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="penilaian">
                                    <i class="fas fa-chart-bar"></i> Jenis Penilaian
                                </label>
                                <select class="form-control" name="penilaian" id="penilaian">
                                    <option value="">- Pilih Penilaian -</option>
                                    <option value="REVISI" {{($penilaian ?? old('penilaian'))=='REVISI' ? 'selected'
                                        : '' }}>REVISI</option>
                                    <option value="DEVIASI" {{($penilaian ?? old('penilaian'))=='DEVIASI' ? 'selected'
                                        : '' }}>DEVIASI</option>
                                    <option value="PENYERAPAN" {{($penilaian ?? old('penilaian'))=='PENYERAPAN'
                                        ? 'selected' : '' }}>PENYERAPAN</option>
                                    <option value="CAPAIAN" {{($penilaian ?? old('penilaian'))=='CAPAIAN' ? 'selected'
                                        : '' }}>CAPAIAN</option>
                                    <option value="HASIL" {{($penilaian ?? old('penilaian'))=='HASIL' ? 'selected' : ''
                                        }}>HASIL PENILAIAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="semesterGroup">
                            <div class="form-group">
                                <label for="semester">
                                    <i class="fas fa-calendar-alt"></i> Semester
                                </label>
                                <select class="form-control" name="semester" id="semester">
                                    <option value="">- Pilih -</option>
                                    <option value="1" {{($semester ?? old('semester'))=='1' ? 'selected' : '' }}>
                                        Semester 1</option>
                                    <option value="2" {{($semester ?? old('semester'))=='2' ? 'selected' : '' }}>
                                        Semester 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="triwulanGroup">
                            <div class="form-group">
                                <label for="triwulan">
                                    <i class="fas fa-chart-pie"></i> Triwulan
                                </label>
                                <select class="form-control" name="triwulan" id="triwulan">
                                    <option value="">- Pilih -</option>
                                    <option value="1" {{($triwulan ?? old('triwulan'))=='1' ? 'selected' : '' }}>
                                        Triwulan 1</option>
                                    <option value="2" {{($triwulan ?? old('triwulan'))=='2' ? 'selected' : '' }}>
                                        Triwulan 2</option>
                                    <option value="3" {{($triwulan ?? old('triwulan'))=='3' ? 'selected' : '' }}>
                                        Triwulan 3</option>
                                    <option value="4" {{($triwulan ?? old('triwulan'))=='4' ? 'selected' : '' }}>
                                        Triwulan 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="bulanGroup" style="display: none;">
                            <div class="form-group">
                                <label for="bulan">
                                    <i class="fas fa-calendar"></i> Bulan
                                </label>
                                <select class="form-control" name="bulan" id="bulan">
                                    <option value="">- Pilih -</option>
                                    <option value="1" {{($bulan ?? old('bulan'))=='1' ? 'selected' : '' }}>Januari
                                    </option>
                                    <option value="2" {{($bulan ?? old('bulan'))=='2' ? 'selected' : '' }}>Februari
                                    </option>
                                    <option value="3" {{($bulan ?? old('bulan'))=='3' ? 'selected' : '' }}>Maret
                                    </option>
                                    <option value="4" {{($bulan ?? old('bulan'))=='4' ? 'selected' : '' }}>April
                                    </option>
                                    <option value="5" {{($bulan ?? old('bulan'))=='5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{($bulan ?? old('bulan'))=='6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{($bulan ?? old('bulan'))=='7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{($bulan ?? old('bulan'))=='8' ? 'selected' : '' }}>Agustus
                                    </option>
                                    <option value="9" {{($bulan ?? old('bulan'))=='9' ? 'selected' : '' }}>September
                                    </option>
                                    <option value="10" {{($bulan ?? old('bulan'))=='10' ? 'selected' : '' }}>Oktober
                                    </option>
                                    <option value="11" {{($bulan ?? old('bulan'))=='11' ? 'selected' : '' }}>November
                                    </option>
                                    <option value="12" {{($bulan ?? old('bulan'))=='12' ? 'selected' : '' }}>Desember
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun">
                                    <i class="fas fa-calendar"></i> Tahun
                                </label>
                                <select class="form-control" name="tahun" id="tahun">
                                    <option value="">- Pilih -</option>
                                    <option value="2025" {{($tahun ?? old('tahun'))=='2025' ? 'selected' : '' }}>2025
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="d-block">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-chart-bar"></i> TAMPILKAN
                                            </button>
                                            @if($penilaian ?? false)
                                            <button type="button" class="btn btn-danger ml-1" onclick="exportChartToPDF()">
                                                <i class="fas fa-file-pdf"></i> EXPORT PDF
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-secondary ml-1" onclick="resetForm()">
                                                <i class="fas fa-redo"></i> RESET
                                            </button>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Horizontal Bar Chart -->
    <div class="col-md-12 mt-3">
        <div class="card">
            <div id="chartContainerHorizontal" style="height: 500px; width: 100%;"></div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    let skpd = @json($skpd);
    let penilaianType = "{{ $penilaian ?? '' }}";
    console.log(skpd);

    // Function to reset form
    function resetForm() {
        document.getElementById('chartForm').reset();
        updateFilterVisibility();
    }
    
    // Function to update filter visibility based on penilaian type
    function updateFilterVisibility() {
        const penilaian = document.getElementById('penilaian').value;
        const semesterGroup = document.getElementById('semesterGroup');
        const triwulanGroup = document.getElementById('triwulanGroup');
        const bulanGroup = document.getElementById('bulanGroup');
        
        if (penilaian === 'REVISI') {
            // Show only Semester and Tahun for REVISI
            semesterGroup.style.display = 'block';
            triwulanGroup.style.display = 'none';
            bulanGroup.style.display = 'none';
        } else if (penilaian === 'DEVIASI') {
            // Show only Bulan and Tahun for DEVIASI
            semesterGroup.style.display = 'none';
            triwulanGroup.style.display = 'none';
            bulanGroup.style.display = 'block';
        } else if (penilaian === 'PENYERAPAN') {
            // Show only Bulan and Tahun for PENYERAPAN
            semesterGroup.style.display = 'none';
            triwulanGroup.style.display = 'none';
            bulanGroup.style.display = 'block';
        } else if (penilaian === 'CAPAIAN') {
            // Show only Triwulan and Tahun for CAPAIAN
            semesterGroup.style.display = 'none';
            triwulanGroup.style.display = 'block';
            bulanGroup.style.display = 'none';
        } else if (penilaian === 'HASIL') {
            // Show Semester, Triwulan, Bulan, and Tahun for HASIL
            semesterGroup.style.display = 'block';
            triwulanGroup.style.display = 'block';
            bulanGroup.style.display = 'block';
        } else {
            // Hide all filters for other penilaian types
            semesterGroup.style.display = 'none';
            triwulanGroup.style.display = 'none';
            bulanGroup.style.display = 'none';
        }
    }
    
    // Function to get chart title based on penilaian type
    function getChartTitle(penilaian) {
        switch(penilaian) {
            case 'REVISI':
                return 'NILAI SKOR IT REVISI DPA PER SKPD';
            case 'DEVIASI':
                return 'NILAI DEVIASI DPA PER SKPD';
            case 'PENYERAPAN':
                return 'NILAI PENYERAPAN ANGGARAN PER SKPD';
            case 'CAPAIAN':
                return 'SKOR INDIKATOR TERTIMBANG CAPAIAN (35%) PER SKPD';
            case 'HASIL':
                return 'HASIL PENILAIAN SKPD';
            default:
                return 'CAPAIAN PER SKPD';
        }
    }
    
    // Function to update triwulan options based on semester
    function updateTriwulanOptions() {
        const semester = document.getElementById('semester').value;
        const triwulanSelect = document.getElementById('triwulan');
        
        if (semester === '1') {
            // Show only Triwulan 1 and 2 for Semester 1
            triwulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="1" {{($triwulan ?? old('triwulan'))=='1' ? 'selected' : '' }}>Triwulan 1</option>
                <option value="2" {{($triwulan ?? old('triwulan'))=='2' ? 'selected' : '' }}>Triwulan 2</option>
            `;
        } else if (semester === '2') {
            // Show only Triwulan 3 and 4 for Semester 2
            triwulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="3" {{($triwulan ?? old('triwulan'))=='3' ? 'selected' : '' }}>Triwulan 3</option>
                <option value="4" {{($triwulan ?? old('triwulan'))=='4' ? 'selected' : '' }}>Triwulan 4</option>
            `;
        } else {
            // Show all triwulan when no semester selected
            triwulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="1" {{($triwulan ?? old('triwulan'))=='1' ? 'selected' : '' }}>Triwulan 1</option>
                <option value="2" {{($triwulan ?? old('triwulan'))=='2' ? 'selected' : '' }}>Triwulan 2</option>
                <option value="3" {{($triwulan ?? old('triwulan'))=='3' ? 'selected' : '' }}>Triwulan 3</option>
                <option value="4" {{($triwulan ?? old('triwulan'))=='4' ? 'selected' : '' }}>Triwulan 4</option>
            `;
        }
    }
    
    // Function to update bulan options based on triwulan
    function updateBulanOptions() {
        const triwulan = document.getElementById('triwulan').value;
        const bulanSelect = document.getElementById('bulan');
        
        if (triwulan === '1') {
            // Show Januari, Februari, Maret for Triwulan 1
            bulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="1" {{($bulan ?? old('bulan'))=='1' ? 'selected' : '' }}>Januari</option>
                <option value="2" {{($bulan ?? old('bulan'))=='2' ? 'selected' : '' }}>Februari</option>
                <option value="3" {{($bulan ?? old('bulan'))=='3' ? 'selected' : '' }}>Maret</option>
            `;
        } else if (triwulan === '2') {
            // Show April, Mei, Juni for Triwulan 2
            bulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="4" {{($bulan ?? old('bulan'))=='4' ? 'selected' : '' }}>April</option>
                <option value="5" {{($bulan ?? old('bulan'))=='5' ? 'selected' : '' }}>Mei</option>
                <option value="6" {{($bulan ?? old('bulan'))=='6' ? 'selected' : '' }}>Juni</option>
            `;
        } else if (triwulan === '3') {
            // Show Juli, Agustus, September for Triwulan 3
            bulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="7" {{($bulan ?? old('bulan'))=='7' ? 'selected' : '' }}>Juli</option>
                <option value="8" {{($bulan ?? old('bulan'))=='8' ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{($bulan ?? old('bulan'))=='9' ? 'selected' : '' }}>September</option>
            `;
        } else if (triwulan === '4') {
            // Show Oktober, November, Desember for Triwulan 4
            bulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="10" {{($bulan ?? old('bulan'))=='10' ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{($bulan ?? old('bulan'))=='11' ? 'selected' : '' }}>November</option>
                <option value="12" {{($bulan ?? old('bulan'))=='12' ? 'selected' : '' }}>Desember</option>
            `;
        } else {
            // Show all months when no triwulan selected
            bulanSelect.innerHTML = `
                <option value="">- Pilih -</option>
                <option value="1" {{($bulan ?? old('bulan'))=='1' ? 'selected' : '' }}>Januari</option>
                <option value="2" {{($bulan ?? old('bulan'))=='2' ? 'selected' : '' }}>Februari</option>
                <option value="3" {{($bulan ?? old('bulan'))=='3' ? 'selected' : '' }}>Maret</option>
                <option value="4" {{($bulan ?? old('bulan'))=='4' ? 'selected' : '' }}>April</option>
                <option value="5" {{($bulan ?? old('bulan'))=='5' ? 'selected' : '' }}>Mei</option>
                <option value="6" {{($bulan ?? old('bulan'))=='6' ? 'selected' : '' }}>Juni</option>
                <option value="7" {{($bulan ?? old('bulan'))=='7' ? 'selected' : '' }}>Juli</option>
                <option value="8" {{($bulan ?? old('bulan'))=='8' ? 'selected' : '' }}>Agustus</option>
                <option value="9" {{($bulan ?? old('bulan'))=='9' ? 'selected' : '' }}>September</option>
                <option value="10" {{($bulan ?? old('bulan'))=='10' ? 'selected' : '' }}>Oktober</option>
                <option value="11" {{($bulan ?? old('bulan'))=='11' ? 'selected' : '' }}>November</option>
                <option value="12" {{($bulan ?? old('bulan'))=='12' ? 'selected' : '' }}>Desember</option>
            `;
        }
    }
    
    // Handle penilaian change
    document.getElementById('penilaian').addEventListener('change', function() {
        updateFilterVisibility();
    });
    
    // Handle semester change
    document.getElementById('semester').addEventListener('change', function() {
        updateTriwulanOptions();
        updateBulanOptions(); // Also update bulan when triwulan options change
    });
    
    // Handle triwulan change
    document.getElementById('triwulan').addEventListener('change', function() {
        updateBulanOptions();
    });
    
    // Initialize filter visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateFilterVisibility();
        updateTriwulanOptions();
        updateBulanOptions();
    });

    // Sortir SKPD berdasarkan nilai skor dari terendah ke tertinggi
    skpd.sort((a, b) => {
        return a.y - b.y;
    });

    skpd = skpd.map(item => ({
        label: item.label, // Nama SKPD tetap sebagai label di sumbu X
        y: item.y, // Nilai capaian
        indexLabel: item.y.toFixed(2), // Menampilkan nilai Y di atas batang tanpa %
        indexLabelFontWeight: "bold", // Buat teks lebih tebal
        indexLabelFontSize: 14, // Ukuran font lebih besar agar mudah dibaca
        indexLabelFontColor: "black" // Warna teks hitam agar kontras
    }));
    
    // Function to export chart to PDF
    function exportChartToPDF() {
        const penilaian = document.getElementById('penilaian').value;
        const semester = document.getElementById('semester').value;
        const triwulan = document.getElementById('triwulan').value;
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;
        
        // Build export URL with current filter parameters
        let url = '/superadmin/home/export-pdf?' + 
                 'penilaian=' + encodeURIComponent(penilaian) +
                 '&semester=' + encodeURIComponent(semester || '') +
                 '&triwulan=' + encodeURIComponent(triwulan || '') +
                 '&bulan=' + encodeURIComponent(bulan || '') +
                 '&tahun=' + encodeURIComponent(tahun || '');
        
        // Open PDF in new window
        window.open(url, '_blank');
    }

    window.onload = function () {
        // Debug: Log sorted data untuk memastikan konsistensi
        console.log("Data for Vertical Chart:", skpd);
        
        // Vertical Column Chart (Only Chart)
        var chartVertical = new CanvasJS.Chart("chartContainerHorizontal", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: getChartTitle(penilaianType),
                fontSize: 18,
                fontWeight: "bold"
            },
            axisY: {
                title: "Nilai",
                titleFontSize: 14
            },
            axisX: {
                title: "SKPD",  
                labelAngle: -45, // Miringkan agar tidak bertabrakan
                labelFontSize: 12,
                labelAutoFit: false, // Paksa tampil semua label
                interval: 1, // Pastikan semua label muncul
                titleFontSize: 14
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.00",
                dataPoints: skpd, // Menggunakan data yang sama sudah di-sortir
                color: "#28a745" // Green color for vertical chart
            }]
        });
        chartVertical.render();
    }
</script>
@endpush
