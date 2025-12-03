@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Revisi</h3>

                <div class="card-tools">
                    <div class="d-flex align-items-center gap-2">
                        <select id="bulan_input" class="form-control form-control-sm" style="width: auto;">
                            <option value="">Pilih Bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                        <input type="number" id="tahun_input" class="form-control form-control-sm" placeholder="Tahun" min="2020" max="2030" style="width: 100px;">
                        <button type="button" class="btn btn-success btn-sm" onclick="insertAllSkpd(this)">
                            <i class="fas fa-plus"></i> Masukkan Semua SKPD
                        </button>
                        <a href="/superadmin/ikpa/add" class='btn btn-sm btn-primary'>Tambah Data</a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>SKPD</th>
                            <th>Tahun</th>
                            <th>Semester</th>
                            <th>Triwulan</th>
                            <th>Bulan</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr style="font-size:14px">
                            <td>{{$key + 1}}</td>
                            <td>{{$item->skpd == null ? null : $item->skpd->nama}}</td>
                            <td>{{$item->tahun}}</td>
                            <td>{{$item->semester}}</td>
                            <td>{{$item->triwulan}}</td>
                            <td>{{$item->bulan}}</td>
                            <td>
                                <table class="table table-sm" style="border: 1px solid black; text-align:center">
                                    <thead>
                                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                                            <th style="border: 1px solid black">Indikator</th>
                                            <th style="border: 1px solid black">Skor</th>
                                            <th style="border: 1px solid black">Bobot</th>
                                            <th style="border: 1px solid black">Skor Indikator Tertimbang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                            <td style="border: 1px solid black">Revisi DPA</td>
                                            <td style="border: 1px solid black">{{$item->skorRevisi($item->semester)}}
                                            </td>
                                            <td style="border: 1px solid black">15 %</td>
                                            <td style="border: 1px solid black">
                                                {{$item->skorRevisiTertimbang($item->semester)}}</td>
                                        </tr>
                                        {{-- <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                            <td style="border: 1px solid black">Deviasi DPA</td>
                                            <td style="border: 1px solid black">

                                                {{number_format($item->skorDeviasi($item->tahun,$item->bulan),2)}}</td>
                                            <td style="border: 1px solid black">20 %</td>
                                            <td style="border: 1px solid black">
                                                {{number_format($item->skorDeviasiTertimbang($item->tahun,$item->bulan),2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                            <td style="border: 1px solid black">Penyerapan Anggaran</td>
                                            <td style="border: 1px solid black">
                                                {{number_format($item->skorPenyerapan($item->tahun,$item->bulan),2)}}
                                            </td>
                                            <td style="border: 1px solid black">30 %</td>
                                            <td style="border: 1px solid black">
                                                {{number_format($item->skorPenyerapanTertimbang($item->tahun,$item->bulan),2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                            <td style="border: 1px solid black">Capaian Output</td>
                                            <td style="border: 1px solid black">0</td>
                                            <td style="border: 1px solid black">40 %</td>
                                            <td style="border: 1px solid black">0</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <a href="/superadmin/ikpa/revisi/{{$item->id}}"
                                    class="btn btn-success btn-sm rounded-pill">Revisi
                                </a>

                            </td>
                            <td class="text-right">

                                <a href="/superadmin/ikpa/edit/{{$item->id}}" class="btn btn-sm btn-success"><i
                                        class="fa fa-edit"></i></a>
                                <a href="/superadmin/ikpa/delete/{{$item->id}}" class="btn btn-sm btn-danger"
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
function insertAllSkpd(button) {
    const bulan = document.getElementById('bulan_input').value;
    const tahun = document.getElementById('tahun_input').value;
    
    if (!bulan || !tahun) {
        alert('Silakan isi bulan dan tahun terlebih dahulu!');
        return;
    }
    
    if (tahun < 2020 || tahun > 2030) {
        alert('Tahun harus antara 2020-2030!');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin memasukkan semua SKPD untuk bulan ${bulan} tahun ${tahun}?`)) {
        // Show loading
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        button.disabled = true;
        
        // Send AJAX request
        fetch('/superadmin/ikpa/revisi/insert-all-skpd', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                bulan: bulan,
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
                    alert('Data SKPD berhasil dimasukkan!');
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            } catch (e) {
                // If it's not JSON, it's probably an HTML error page
                console.error('Response is not JSON:', text);
                alert('Terjadi kesalahan server. Silakan cek console untuk detail.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses data: ' + error.message);
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
