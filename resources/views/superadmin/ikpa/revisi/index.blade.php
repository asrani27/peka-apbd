@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data IKPA</h3>

                <div class="card-tools">
                    <a href="/superadmin/ikpa/add" class='btn btn-sm btn-primary'>Tambah Data</a>
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
                            <th>Nama</th>
                            <th>Jabatan</th>
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
                            <td>{{$item->nama}}</td>
                            <td>{{$item->jabatan}}</td>
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