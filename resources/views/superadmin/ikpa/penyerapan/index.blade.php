@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Penyerapan Anggaran</h3>

                <div class="card-tools">
                    {{-- <a href="/excel/template_deviasi.xlsx" class='btn btn-sm btn-primary' target="_blank">Template
                        Excel</a>
                    <a href="/superadmin/ikpa/deviasi/add" class='btn btn-sm btn-primary'>Tambah
                        Data</a> --}}
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

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                        <tr style="font-size:14px">
                            <td>{{$key + 1}}</td>
                            <td>{{$item->tahun}}</td>
                            <td>{{$item->skpd == null ? null : $item->skpd->nama}}</td>
                            <td>

                                <a href="/superadmin/ikpa/penyerapan/detail/{{$item->id}}"
                                    class="btn btn-sm {{$item->detail()->sum('kolom_c') > 0 ? 'btn-success' : 'btn-danger'}}">
                                    <i class="fa fa-eye"></i> Detail Penyerapan Anggaran
                                </a>
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