@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Deviasi</h3>

                <div class="card-tools">
                    <a href="/excel/template_deviasi.xlsx" class='btn btn-sm btn-primary' target="_blank">Template
                        Excel</a>
                    <a href="/superadmin/ikpa/deviasi/add" class='btn btn-sm btn-primary'>Tambah
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
                            <th>Semester</th>
                            <th>Triwulan</th>
                            <th>Bulan</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Tarik Data</th>
                            <th>Import Data</th>
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
                                <a href="#" class="btn btn-success">
                                    Tarik Data
                                </a>
                            </td>
                            <td>
                                <div class="col-12 d-flex align-items-center gap-2">
                                    <form method="post" action="/superadmin/ikpa/deviasi/{{$item->id}}"
                                        enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <input type="file" name="file" class="form-control">
                                        <button type="submit" class="btn btn-primary">Import Data</button>
                                    </form>
                                </div>


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