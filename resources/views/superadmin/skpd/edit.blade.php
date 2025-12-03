@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit SKPD</h3>
                <div class="card-tools">
                    <a href="/superadmin/skpd" class="btn btn-sm btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="/superadmin/skpd/update/{{ $skpd->id }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode">Kode SKPD</label>
                                <input type="text" class="form-control" id="kode" name="kode" 
                                       value="{{ old('kode', $skpd->kode) }}" required>
                                @error('kode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama SKPD</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="{{ old('nama', $skpd->nama) }}" required>
                                @error('nama')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="/superadmin/skpd" class="btn btn-default ml-2">
                                    <i class="fa fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
