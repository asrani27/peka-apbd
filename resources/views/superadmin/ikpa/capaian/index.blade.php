@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Capaian</h3>

                <div class="card-tools">
                    <div class="d-flex align-items-center gap-2">
                        <select id="tahun_input" class="form-control form-control-sm" style="width: 100px;"
                            onchange="filterByTahun()">
                            <option value="">Pilih Tahun</option>
                            <option value="2025" {{ $tahun=='2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ $tahun=='2026' ? 'selected' : '' }}>2026</option>
                        </select>
                        <button type="button" class="btn btn-success btn-sm" onclick="insertAllSkpd(this)">
                            <i class="fas fa-plus"></i> Masukkan SKPD
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteAllSkpd(this)">
                            <i class="fas fa-trash"></i> Hapus SKPD
                        </button>
                        <a href="/excel/template_capaian.xlsx" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fa fa-excel-o"></i> Template Capaian
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>SKPD</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr style="font-size:14px">
                            <td>{{$key + 1}}</td>
                            <td>{{$item->tahun}}</td>
                            <td>{{$item->skpd == null ? null : $item->skpd->nama}}</td>
                            <td>
                                <a href="/superadmin/ikpa/capaian/detail/{{$item->id}}" 
                                   class="btn btn-sm {{$item->detail()->count() > 0 ? 'btn-success' : 'btn-danger'}}">
                                    <i class="fa fa-eye"></i> Detail Capaian
                                </a>
                            </td>
                            <td>

                                <a href="/superadmin/ikpa/capaian/edit/{{$item->id}}" class="btn btn-sm btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="/superadmin/ikpa/capaian/delete/{{$item->id}}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin dihapus?');"><i class="fa fa-trash"></i></a>
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

@endsection

@push('js')
<script>
    // Restore selected year from localStorage on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTahun = localStorage.getItem('selectedTahun');
        if (savedTahun) {
            const tahunSelect = document.getElementById('tahun_input');
            tahunSelect.value = savedTahun;
            localStorage.removeItem('selectedTahun'); // Clear after restoring
        }
    });

    function filterByTahun() {
        const tahun = document.getElementById('tahun_input').value;
        const currentUrl = new URL(window.location);
        
        if (tahun) {
            currentUrl.searchParams.set('tahun', tahun);
        } else {
            currentUrl.searchParams.delete('tahun');
        }
        
        // Save selected year to localStorage for restoration after page load
        localStorage.setItem('selectedTahun', tahun);
        
        window.location.href = currentUrl.toString();
    }

    function insertAllSkpd(button) {
        const tahun = document.getElementById('tahun_input').value;
        
        if (!tahun) {
            alert('Silakan pilih tahun terlebih dahulu!');
            return;
        }
        
        if (tahun < 2024 || tahun > 2026) {
            alert('Tahun harus antara 2024-2026!');
            return;
        }
        
        if (confirm(`Apakah Anda yakin ingin memasukkan semua SKPD untuk tahun ${tahun}?`)) {
            // Save selected year to localStorage before reloading
            localStorage.setItem('selectedTahun', tahun);
            
            // Show loading
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            button.disabled = true;
            
            // Send AJAX request
            fetch('/superadmin/ikpa/capaian/insert-all-skpd', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tahun: tahun
                })
            })
            .then(response => {
                // Check if response is ok (status 200-299)
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Get response as text first
            })
            .then(text => {
                try {
                    // Try to parse as JSON
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                        // Clear localStorage if there's an error
                        localStorage.removeItem('selectedTahun');
                    }
                } catch (e) {
                    // If it's not JSON, it's probably an HTML error page
                    console.error('Response is not JSON:', text);
                    alert('Terjadi kesalahan server. Silakan cek console untuk detail.');
                    // Clear localStorage if there's an error
                    localStorage.removeItem('selectedTahun');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses data: ' + error.message);
                // Clear localStorage if there's an error
                localStorage.removeItem('selectedTahun');
            })
            .finally(() => {
                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    }

    function deleteAllSkpd(button) {
        const tahun = document.getElementById('tahun_input').value;
        
        if (!tahun) {
            alert('Silakan pilih tahun terlebih dahulu!');
            return;
        }
        
        if (tahun < 2024 || tahun > 2026) {
            alert('Tahun harus antara 2024-2026!');
            return;
        }
        
        if (confirm(`Apakah Anda yakin ingin menghapus SEMUA data SKPD untuk tahun ${tahun}? Tindakan ini tidak dapat dibatalkan!`)) {
            // Save selected year to localStorage before reloading
            localStorage.setItem('selectedTahun', tahun);
            
            // Show loading
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
            button.disabled = true;
            
            // Send AJAX request
            fetch('/superadmin/ikpa/capaian/delete-all-skpd', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tahun: tahun
                })
            })
            .then(response => {
                // Check if response is ok (status 200-299)
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text(); // Get response as text first
            })
            .then(text => {
                try {
                    // Try to parse as JSON
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                        // Clear localStorage if there's an error
                        localStorage.removeItem('selectedTahun');
                    }
                } catch (e) {
                    // If it's not JSON, it's probably an HTML error page
                    console.error('Response is not JSON:', text);
                    alert('Terjadi kesalahan server. Silakan cek console untuk detail.');
                    // Clear localStorage if there's an error
                    localStorage.removeItem('selectedTahun');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memproses data: ' + error.message);
                // Clear localStorage if there's an error
                localStorage.removeItem('selectedTahun');
            })
            .finally(() => {
                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    }
</script>
@endpush
