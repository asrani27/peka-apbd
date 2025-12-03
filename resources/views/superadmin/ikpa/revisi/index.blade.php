@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Revisi</h3>

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