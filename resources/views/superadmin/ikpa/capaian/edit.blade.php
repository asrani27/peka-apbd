@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('error') }}
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Capaian</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('capaian.update', $data->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="skpd">SKPD</label>
                                <input type="text" class="form-control" value="{{ $data->skpd->nama }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input type="text" class="form-control" value="{{ $data->tahun }}" readonly>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4 mb-3">Ketepatan Waktu Pelaporan</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_tw1">Periode TW 1</label>
                                <select name="periode_tw1" id="periode_tw1" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya" {{ $data->periode_tw1 == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $data->periode_tw1 == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_tw2">Periode TW 2</label>
                                <select name="periode_tw2" id="periode_tw2" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya" {{ $data->periode_tw2 == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $data->periode_tw2 == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_tw3">Periode TW 3</label>
                                <select name="periode_tw3" id="periode_tw3" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya" {{ $data->periode_tw3 == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $data->periode_tw3 == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="periode_tw4">Periode TW 4</label>
                                <select name="periode_tw4" id="periode_tw4" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="Ya" {{ $data->periode_tw4 == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    <option value="Tidak" {{ $data->periode_tw4 == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h4 class="mt-4 mb-3">Bobot Penilaian IKPA</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bobot_triwulan">Bobot Nilai Triwulanan</label>
                                <input type="number" step="0.01" name="bobot_triwulan" id="bobot_triwulan" 
                                       class="form-control" value="{{ $data->bobot_triwulan ?? 0.25 }}" placeholder="0.25">
                                <small class="form-text text-muted">Bobot untuk nilai triwulanan (default: 0.25 = 25%)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bobot_capaian">Bobot Nilai Capaian Output</label>
                                <input type="number" step="0.01" name="bobot_capaian" id="bobot_capaian" 
                                       class="form-control" value="{{ $data->bobot_capaian ?? 0.70 }}" placeholder="0.70">
                                <small class="form-text text-muted">Bobot untuk nilai capaian output (default: 0.70 = 70%)</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bobot_ketepatan">Bobot Nilai Ketepatan Waktu</label>
                                <input type="number" step="0.01" name="bobot_ketepatan" id="bobot_ketepatan" 
                                       class="form-control" value="{{ $data->bobot_ketepatan ?? 0.30 }}" placeholder="0.30">
                                <small class="form-text text-muted">Bobot untuk nilai ketepatan waktu (default: 0.30 = 30%)</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h4 class="mt-4 mb-3">Import Excel (Opsional)</h4>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Jika Anda mengupload file Excel, data detail yang ada akan diganti dengan data dari file baru.
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="file">Pilih File Excel (.xlsx, .xls, .csv)</label>
                                <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls,.csv">
                                <small class="form-text text-muted">
                                    Kosongkan jika tidak ingin mengubah data detail
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('capaian.detail', $data->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
