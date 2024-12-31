@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Data</h3>

            </div>
            <form method="POST" action="/superadmin/ikpa/add">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">SKPD</label>
                        <select class="form-control" required name="skpd_id">
                            <option value="">-skpd-</option>
                            @foreach (skpd() as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">TAHUN</label>
                        <select class="form-control" required name="tahun">
                            <option value="">-tahun-</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">SEMESTER</label>
                        <select class="form-control" required name="semester">
                            <option value="">-tahun-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">TRIWULAN</label>
                        <select class="form-control" required name="triwulan">
                            <option value="">-tahun-</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">BULAN</label>

                        <select class="form-control" required name="bulan">
                            <option value="">-bulan-</option>
                            @foreach (bulan() as $item)
                            <option value="{{$item}}">{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">NAMA</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">JABATAN</label>
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection