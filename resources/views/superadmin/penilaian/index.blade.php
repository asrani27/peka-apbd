@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data SKPD</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th rowspan="2" style="vertical-align: middle; text-align:center">No</th>
                            <th rowspan="2" style="vertical-align: middle; text-align:center">Kode</th>
                            <th rowspan="2" style="vertical-align: middle; text-align:center">Nama</th>
                            <th colspan="5" style="vertical-align: middle; text-align:center">Nilai Capaian</th>
                            <th colspan="2" style="vertical-align: middle; text-align:center">Periode</th>
                        </tr>
                        <tr class="bg-primary">
                            <th style="vertical-align: middle; text-align:center">Revisi DPA</th>
                            <th style="vertical-align: middle; text-align:center">Deviasi DPA</th>
                            <th style="vertical-align: middle; text-align:center">Penyerapan Anggaran</th>
                            <th style="vertical-align: middle; text-align:center">Capaian Output</th>
                            <th style="vertical-align: middle; text-align:center">Total Nilai Capaian</th>
                            <th style="vertical-align: middle; text-align:center">Semester</th>
                            <th style="vertical-align: middle; text-align:center">Triwulan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skpd as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->kode}}</td>
                            <td>{{$item->nama}}</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
                            <td style="text-align: center">0</td>
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