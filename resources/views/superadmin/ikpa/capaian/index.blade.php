@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Deviasi</h3>

                <div class="card-tools">
                    <a href="/excel/template_capaian.xlsx" class='btn btn-sm btn-primary' target="_blank">Template
                        Excel</a>
                    <a href="/superadmin/ikpa/capaian/add" class='btn btn-sm btn-primary'>Tambah
                        Data</a>
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
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr style="font-size:14px">
                            <td>{{$key + 1}}</td>
                            <td>{{$item->skpd == null ? null : $item->skpd->nama}}</td>
                            <td>{{$item->tahun}}</td>
                            <td>
                                <a href="/superadmin/ikpa/capaian/detail/{{$item->id}}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i> Lihat Detail Capaian
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