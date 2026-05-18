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
                    <a href="/superadmin/penilaian/jadwal/create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </a>
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
                                <form method="GET" action="/superadmin/penilaian/jadwal">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tahun_filter">
                                                    <i class="fas fa-calendar"></i> Tahun
                                                </label>
                                                <select class="form-control" id="tahun_filter" name="tahun">
                                                    <option value="">Semua Tahun</option>
                                                    @php
                                                        $currentYear = date('Y');
                                                        for($y = $currentYear; $y >= $currentYear - 5; $y--):
                                                    @endphp
                                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                    @php endfor; @endphp
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
                                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div class="d-block">
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        <i class="fas fa-search"></i> Filter
                                                    </button>
                                                    <a href="/superadmin/penilaian/jadwal" class="btn btn-default btn-sm ml-1">
                                                        <i class="fas fa-redo"></i> Reset
                                                    </a>
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
                                <th style="text-align: center;">Tahun</th>
                                <th>Periode</th>
                                <th style="text-align: center;">Tanggal Mulai</th>
                                <th style="text-align: center;">Tanggal Selesai</th>
                                <th style="text-align: center;">Status</th>
                                <th style="width: 120px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $key => $item)
                            <tr>
                                <td style="text-align: center;">{{$key + 1}}</td>
                                <td style="text-align: center;">{{$item->tahun}}</td>
                                <td>{{$item->periode}}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($item->tanggal_mulai)) }}</td>
                                <td style="text-align: center;">{{ date('d/m/Y', strtotime($item->tanggal_selesai)) }}</td>
                                <td style="text-align: center;">
                                    @switch($item->status)
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
                                <td style="text-align: center;">
                                    <a href="/superadmin/penilaian/jadwal/edit/{{$item->id}}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/superadmin/penilaian/jadwal/delete/{{$item->id}}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data jadwal penilaian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection