@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Revisi - {{ $revisi->skpd->nama ?? 'SKPD Tidak Diketahui' }} ({{
                    $revisi->tahun }})</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-file-excel"></i> Import Excel
                    </button>
                    <a href="/excel/template_revisi.xlsx" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fa fa-download"></i> Download Template
                    </a>
                    <a href="/superadmin/ikpa/revisi" class="btn btn-warning btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Data Revisi Detail -->
                <div class="row">
                    <div class="col-12">
                        <h2>Data Revisi Detail</h2>

                        @if($revisi->revisiDetail && $revisi->revisiDetail->count() > 0)
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table width="100%" cellpadding="5">
                                    <tr class="bg-warning" style="font-size:14px;font-weight:bold;text-align:center">
                                        <td style="border:1px solid black; min-width:50px;">NO</td>
                                        <td style="border:1px solid black; min-width:100px;">SEMESTER</td>
                                        <td style="border:1px solid black; min-width:120px;">TANGGAL NODIN</td>
                                        <td style="border:1px solid black; min-width:120px;">TANGGAL PENGESAHAN</td>
                                        <td style="border:1px solid black; min-width:100px;">REVISI KE</td>
                                        <td style="border:1px solid black; min-width:150px;">JENIS REVISI</td>
                                        <td style="border:1px solid black; min-width:150px;">PAGU AWAL</td>
                                        <td style="border:1px solid black; min-width:150px;">PAGU AKHIR</td>
                                        <td style="border:1px solid black; min-width:80px;">AKSI</td>



                                    </tr>
                                    @foreach($revisi->revisiDetail as $key => $detail)
                                    <tr style="font-size:12px; font-family: 'Roboto Mono', monospace;">
                                        <td style="border:1px solid black;text-align:center">{{ $key + 1 }}</td>
                                        <td style="border:1px solid black;text-align:center">
                                            <span
                                                style="padding: 2px 8px; border-radius: 3px; font-size: 11px; font-weight: bold; 
                                                   {{ $detail->semester == 1 ? 'background-color: #17a2b8; color: white;' : 'background-color: #ffc107; color: black;' }}">
                                                SEMESTER {{ $detail->semester }}
                                            </span>
                                        </td>
                                        <td style="border:1px solid black">{{ $detail->tanggal_nodin ? date('d/m/Y',
                                            strtotime($detail->tanggal_nodin)) : '-' }}</td>
                                        <td style="border:1px solid black">{{ $detail->tanggal_pengesahan ?
                                            date('d/m/Y', strtotime($detail->tanggal_pengesahan)) : '-' }}</td>
                                        <td style="border:1px solid black">{{ $detail->revisi_ke ?? '-' }}</td>
                                        <td style="border:1px solid black">{{ $detail->jenis_revisi ?? '-' }}</td>
                                        <td
                                            style="border:1px solid black;text-align:right;font-family: 'Roboto Mono', monospace;">
                                            Rp. {{ number_format($detail->pagu_awal, 0, ',', '.') }}
                                        </td>
                                        <td
                                            style="border:1px solid black;text-align:right;font-family: 'Roboto Mono', monospace;">
                                            Rp. {{ number_format($detail->pagu_akhir, 0, ',', '.') }}
                                        </td>
                                        <td style="border:1px solid black;text-align:center">
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="editDetail({{ $detail->id }})"
                                                style="padding: 2px 6px; font-size: 11px; margin-right: 3px;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteDetail({{ $detail->id }})"
                                                style="padding: 2px 6px; font-size: 11px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>

                        <!-- Jumlah Revisi per Semester -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Jumlah Revisi per Semester</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th style="width: 50%; text-align: center;">Semester</th>
                                                <th style="width: 50%; text-align: center;">Jumlah Revisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="badge badge-info">Semester 1</span>
                                                </td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ $revisi->jumlahRevisiSemester1() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="badge badge-warning">Semester 2</span>
                                                </td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ $revisi->jumlahRevisiSemester2() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- NKRA per Semester -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">NKRA per Semester</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th style="width: 50%; text-align: center;">Semester</th>
                                                <th style="width: 50%; text-align: center;">NKRA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="badge badge-success">Semester 1</span>
                                                </td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ $revisi->nkraSemester1() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="badge badge-danger">Semester 2</span>
                                                </td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ $revisi->nkraSemester2() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- NKRA Tahunan -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">NKRA Tahunan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-secondary text-white">
                                            <tr>
                                                <th style="width: 50%; text-align: center;">Periode</th>
                                                <th style="width: 50%; text-align: center;">NKRA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span class="badge badge-primary">Tahunan</span>
                                                </td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold; font-size: 1.1em;">
                                                    {{ number_format($revisi->nkraTahunan(), 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Indikator -->
                        @if($revisi->revisiDetail && $revisi->revisiDetail->count() > 0)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Tabel Indikator</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">Indikator</th>
                                                <th style="width: 25%;">Skor</th>
                                                <th style="width: 20%;">Bobot</th>
                                                <th style="width: 25%;">Skor IT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Revisi DPA Semester 1</strong></td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace;">
                                                    {{ number_format($revisi->skorRevisiSemester1(), 2, ',', '.') }}
                                                </td>
                                                <td style="text-align: center;">15%</td>
                                                <td
                                                    style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ number_format($revisi->skorITSemester1(), 2, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Revisi DPA Semester 2</strong></td>
                                                <td style="text-align: center; font-family: 'Roboto Mono', monospace;">
                                                    {{ number_format($revisi->skorRevisiSemester2(), 2, ',', '.') }}
                                                </td>
                                                <td style="text-align: center;">15%</td>
                                                <td
                                                    style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ number_format($revisi->skorITSemester2(), 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="bg-info text-white">
                                                <th>Total</th>
                                                <th style="text-align: center; font-family: 'Roboto Mono', monospace;">
                                                    {{ number_format($revisi->totalSkorRevisi(), 2, ',', '.') }}
                                                </th>
                                                <th style="text-align: center;">30%</th>
                                                <th
                                                    style="text-align: center; font-family: 'Roboto Mono', monospace; font-weight: bold;">
                                                    {{ number_format($revisi->totalSkorIT(), 2, ',', '.') }}
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="alert alert-info mt-3" style="margin-bottom: 0;">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Keterangan:</strong><br>
                                    • <strong>Skor Semester 1:</strong> NKRA Semester 1<br>
                                    • <strong>Skor Semester 2:</strong> NKRA Tahunan<br>
                                    • <strong>Bobot:</strong> 15% per semester (Total 30%)<br>
                                    • <strong>Skor IT:</strong> Skor × Bobot (15%) per semester<br>
                                    • <strong>Rumus:</strong> =IF(E12=1; U45; V45) → IF(Semester=1; NKRA Semester1; NKRA
                                    Tahunan)<br>
                                    • <strong>Total:</strong> Penjumlahan Semester 1 + Semester 2
                                </div>
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada data revisi detail. Silakan import data
                            terlebih dahulu.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Revisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importForm" action="/superadmin/ikpa/revisi/{{ $revisi->id }}/import" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".xlsx,.xls,.csv"
                            required>
                        <small class="form-text text-muted">
                            Format file: .xlsx, .xls, .csv (Max 2MB)<br>
                            Pastikan file mengikuti template yang telah disediakan.
                        </small>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> <strong>Panduan Import:</strong><br>
                        • Data Semester 1: Baris 5-16<br>
                        • Data Semester 2: Baris 19-30<br>
                        • Kolom C: Tanggal Nodin<br>
                        • Kolom D: Tanggal Pengesahan<br>
                        • Kolom E: Revisi Ke<br>
                        • Kolom F: Jenis Revisi<br>
                        • Kolom G: Pagu Awal<br>
                        • Kolom H: Pagu Akhir
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="importBtn">
                        <i class="fas fa-upload"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Revisi Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <input type="hidden" id="editId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editTanggalNodin">Tanggal Nodin</label>
                        <input type="date" class="form-control" id="editTanggalNodin" name="tanggal_nodin">
                    </div>
                    <div class="form-group">
                        <label for="editTanggalPengesahan">Tanggal Pengesahan</label>
                        <input type="date" class="form-control" id="editTanggalPengesahan" name="tanggal_pengesahan">
                    </div>
                    <div class="form-group">
                        <label for="editRevisiKe">Revisi Ke</label>
                        <input type="text" class="form-control" id="editRevisiKe" name="revisi_ke"
                            placeholder="Contoh: 1, 2, 3">
                    </div>
                    <div class="form-group">
                        <label for="editJenisRevisi">Jenis Revisi</label>
                        <input type="text" class="form-control" id="editJenisRevisi" name="jenis_revisi"
                            placeholder="Contoh: Perubahan Pagu">
                    </div>
                    <div class="form-group">
                        <label for="editPaguAwal">Pagu Awal</label>
                        <input type="number" class="form-control" id="editPaguAwal" name="pagu_awal" placeholder="0">
                    </div>
                    <div class="form-group">
                        <label for="editPaguAkhir">Pagu Akhir</label>
                        <input type="number" class="form-control" id="editPaguAkhir" name="pagu_akhir" placeholder="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="editBtn">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var importBtn = $('#importBtn');
            var originalText = importBtn.html();
            
            // Show loading
            importBtn.html('<i class="fas fa-spinner fa-spin"></i> Mengimport...').prop('disabled', true);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#importModal').modal('hide');
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                            timeout: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan saat import data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            // Keep default error message
                        }
                    }
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorMessage,
                        position: 'topRight'
                    });
                },
                complete: function() {
                    // Restore button
                    importBtn.html(originalText).prop('disabled', false);
                }
            });
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = $(this).serialize();
            var editBtn = $('#editBtn');
            var id = $('#editId').val();
            var originalText = editBtn.html();
            
            // Show loading
            editBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
            
            $.ajax({
                url: '/superadmin/ikpa/revisi/detail/' + id + '/update',
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#editModal').modal('hide');
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                            timeout: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan saat memperbarui data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            // Keep default error message
                        }
                    }
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorMessage,
                        position: 'topRight'
                    });
                },
                complete: function() {
                    // Restore button
                    editBtn.html(originalText).prop('disabled', false);
                }
            });
        });
    });

    function editDetail(id) {
        // Fetch data detail untuk di-edit
        $.ajax({
            url: '/superadmin/ikpa/revisi/detail/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    // Isi form dengan data yang ada
                    $('#editId').val(response.data.id);
                    $('#editTanggalNodin').val(response.data.tanggal_nodin);
                    $('#editTanggalPengesahan').val(response.data.tanggal_pengesahan);
                    $('#editRevisiKe').val(response.data.revisi_ke);
                    $('#editJenisRevisi').val(response.data.jenis_revisi);
                    $('#editPaguAwal').val(response.data.pagu_awal);
                    $('#editPaguAkhir').val(response.data.pagu_akhir);
                    
                    // Tampilkan modal
                    $('#editModal').modal('show');
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = 'Terjadi kesalahan saat mengambil data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                iziToast.error({
                    title: 'Error',
                    message: errorMessage,
                    position: 'topRight'
                });
            }
        });
    }

    function deleteDetail(id) {
        if (confirm('Apakah Anda yakin? Data ini akan dihapus permanen!')) {
            $.ajax({
                url: '/superadmin/ikpa/revisi/detail/' + id + '/delete',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        iziToast.success({
                            title: 'Berhasil',
                            message: response.message,
                            position: 'topRight',
                            timeout: 1500
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(xhr) {
                    var errorMessage = 'Terjadi kesalahan saat menghapus data.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    iziToast.error({
                        title: 'Error',
                        message: errorMessage,
                        position: 'topRight'
                    });
                }
            });
        }
    }
</script>
@endpush
