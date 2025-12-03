@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i> Jadwal Penilaian
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addJadwalModal">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-filter"></i> Filter Jadwal
                                </h3>
                            </div>
                            <div class="card-body">
                                <form id="filterJadwalForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tahun_filter">
                                                    <i class="fas fa-calendar"></i> Tahun
                                                </label>
                                                <select class="form-control" id="tahun_filter" name="tahun">
                                                    <option value="">Semua Tahun</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025" selected>2025</option>
                                                    <option value="2026">2026</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="semester_filter">
                                                    <i class="fas fa-calendar-alt"></i> Semester
                                                </label>
                                                <select class="form-control" id="semester_filter" name="semester">
                                                    <option value="">Semua Semester</option>
                                                    <option value="1">Semester 1</option>
                                                    <option value="2">Semester 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="status_filter">
                                                    <i class="fas fa-info-circle"></i> Status
                                                </label>
                                                <select class="form-control" id="status_filter" name="status">
                                                    <option value="">Semua Status</option>
                                                    <option value="draft">Draft</option>
                                                    <option value="aktif">Aktif</option>
                                                    <option value="selesai">Selesai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="d-block">
                                                    <button type="button" class="btn btn-info btn-sm" onclick="applyJadwalFilters()">
                                                        <i class="fas fa-search"></i> Filter
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-sm ml-1" onclick="resetJadwalFilters()">
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
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th>Kegiatan Penilaian</th>
                                <th style="text-align: center;">Periode</th>
                                <th style="text-align: center;">Tanggal Mulai</th>
                                <th style="text-align: center;">Tanggal Selesai</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Target SKPD</th>
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $jadwalList = [
                                    [
                                        'id' => 1,
                                        'kegiatan' => 'Penilaian Triwulan 1',
                                        'periode' => 'Triwulan 1 - Semester 1',
                                        'tanggal_mulai' => '2025-04-01',
                                        'tanggal_selesai' => '2025-04-30',
                                        'status' => 'aktif',
                                        'target_skpd' => 45
                                    ],
                                    [
                                        'id' => 2,
                                        'kegiatan' => 'Penilaian Semester 1',
                                        'periode' => 'Semester 1',
                                        'tanggal_mulai' => '2025-07-01',
                                        'tanggal_selesai' => '2025-07-31',
                                        'status' => 'draft',
                                        'target_skpd' => 45
                                    ],
                                    [
                                        'id' => 3,
                                        'kegiatan' => 'Penilaian Triwulan 3',
                                        'periode' => 'Triwulan 3 - Semester 2',
                                        'tanggal_mulai' => '2025-10-01',
                                        'tanggal_selesai' => '2025-10-31',
                                        'status' => 'draft',
                                        'target_skpd' => 45
                                    ]
                                ];
                            @endphp
                            
                            @foreach ($jadwalList as $key => $item)
                            <tr>
                                <td style="text-align: center;">{{$key + 1}}</td>
                                <td>{{$item['kegiatan']}}</td>
                                <td style="text-align: center;">{{$item['periode']}}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($item['tanggal_mulai'])) }}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($item['tanggal_selesai'])) }}</td>
                                <td style="text-align: center;">
                                    @switch($item['status'])
                                        @case('draft')
                                            <span class="badge badge-secondary">Draft</span>
                                            @break
                                        @case('aktif')
                                            <span class="badge badge-success">Aktif</span>
                                            @break
                                        @case('selesai')
                                            <span class="badge badge-primary">Selesai</span>
                                            @break
                                    @endswitch
                                </td>
                                <td style="text-align: center;">{{$item['target_skpd']}} SKPD</td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="editJadwal({{$item['id']}})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteJadwal({{$item['id']}})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="addJadwalModal" tabindex="-1" role="dialog" aria-labelledby="addJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJadwalModalLabel">
                    <i class="fas fa-plus"></i> Tambah Jadwal Penilaian
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addJadwalForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kegiatan">
                                    <i class="fas fa-tasks"></i> Kegiatan Penilaian <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">
                                    <i class="fas fa-calendar"></i> Tahun <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="tahun" name="tahun" required>
                                    <option value="">Pilih Tahun</option>
                                    <option value="2024">2024</option>
                                    <option value="2025" selected>2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="semester">
                                    <i class="fas fa-calendar-alt"></i> Semester <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_mulai">
                                    <i class="fas fa-calendar-check"></i> Tanggal Mulai <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal_selesai">
                                    <i class="fas fa-calendar-check"></i> Tanggal Selesai <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="triwulan">
                                    <i class="fas fa-chart-pie"></i> Triwulan
                                </label>
                                <select class="form-control" id="triwulan" name="triwulan">
                                    <option value="">Semua Triwulan</option>
                                    <option value="1">Triwulan 1</option>
                                    <option value="2">Triwulan 2</option>
                                    <option value="3">Triwulan 3</option>
                                    <option value="4">Triwulan 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">
                                    <i class="fas fa-info-circle"></i> Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="aktif">Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">
                                    <i class="fas fa-file-alt"></i> Deskripsi
                                </label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="saveJadwal()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function applyJadwalFilters() {
    const tahun = document.getElementById('tahun_filter').value;
    const semester = document.getElementById('semester_filter').value;
    const status = document.getElementById('status_filter').value;
    
    // Build URL with query parameters
    let url = new URL(window.location.href);
    
    // Add or update parameters
    if (tahun) {
        url.searchParams.set('tahun', tahun);
    } else {
        url.searchParams.delete('tahun');
    }
    
    if (semester) {
        url.searchParams.set('semester', semester);
    } else {
        url.searchParams.delete('semester');
    }
    
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    
    // Redirect to filtered URL
    window.location.href = url.toString();
}

function resetJadwalFilters() {
    // Reset all select elements
    document.getElementById('tahun_filter').value = '';
    document.getElementById('semester_filter').value = '';
    document.getElementById('status_filter').value = '';
    
    // Clear all query parameters and reload
    let url = new URL(window.location.href);
    url.searchParams.delete('tahun');
    url.searchParams.delete('semester');
    url.searchParams.delete('status');
    
    window.location.href = url.toString();
}

function saveJadwal() {
    // Get form data
    const formData = new FormData(document.getElementById('addJadwalForm'));
    
    // Validation
    const kegiatan = formData.get('kegiatan');
    const tahun = formData.get('tahun');
    const semester = formData.get('semester');
    const tanggal_mulai = formData.get('tanggal_mulai');
    const tanggal_selesai = formData.get('tanggal_selesai');
    const status = formData.get('status');
    
    if (!kegiatan || !tahun || !semester || !tanggal_mulai || !tanggal_selesai || !status) {
        alert('Harap lengkapi semua field yang wajib diisi!');
        return;
    }
    
    if (new Date(tanggal_selesai) < new Date(tanggal_mulai)) {
        alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai!');
        return;
    }
    
    // Here you would normally send the data to the server via AJAX
    // For now, we'll just show a success message and close the modal
    alert('Jadwal penilaian berhasil disimpan!');
    $('#addJadwalModal').modal('hide');
    document.getElementById('addJadwalForm').reset();
    
    // Reload the page to show the new data
    setTimeout(() => {
        location.reload();
    }, 1000);
}

function editJadwal(id) {
    // Here you would normally fetch the jadwal data and show edit modal
    alert('Edit jadwal dengan ID: ' + id);
}

function deleteJadwal(id) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
        // Here you would normally send delete request to server
        alert('Jadwal berhasil dihapus!');
        // Reload the page to show updated data
        setTimeout(() => {
            location.reload();
        }, 1000);
    }
}

// Set filter values from URL parameters on page load
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    const tahun = urlParams.get('tahun');
    const semester = urlParams.get('semester');
    const status = urlParams.get('status');
    
    if (tahun) {
        document.getElementById('tahun_filter').value = tahun;
    }
    
    if (semester) {
        document.getElementById('semester_filter').value = semester;
    }
    
    if (status) {
        document.getElementById('status_filter').value = status;
    }
});
</script>
@endpush
