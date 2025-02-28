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
                    <a href="/admin/ikpa/deviasi/add" class='btn btn-sm btn-primary'>Tambah
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
                                <table width="100%" cellpadding="5">
                                    <tr class="bg-warning" style="font-size:10px;font-weight:bold;text-align:center">
                                        <td rowspan="2" style="border:1px solid black">BULAN</td>
                                        <td colspan="4" style="border:1px solid black">RAK Tahunan</td>
                                        <td colspan="4" style="border:1px solid black">Realisasi RAK</td>
                                    </tr>
                                    <tr class="bg-warning" style="font-size:10px;font-weight:bold;text-align:center">
                                        <td style="border:1px solid black">51</td>
                                        <td style="border:1px solid black">52</td>
                                        <td style="border:1px solid black">53</td>
                                        <td style="border:1px solid black">54</td>
                                        <td style="border:1px solid black">51</td>
                                        <td style="border:1px solid black">52</td>
                                        <td style="border:1px solid black">53</td>
                                        <td style="border:1px solid black">54</td>
                                    </tr>
                                    @foreach ($item->detail as $item2)
                                    <tr style="font-size:12px;font-weight:bold;">
                                        <td style=" border:1px solid black">{{$item2->bulan}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_c)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_d)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_e)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_f)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_g)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_h)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_i)}}</td>
                                        <td style=" border:1px solid black;text-align:right">
                                            {{number_format($item2->kolom_j)}}</td>
                                    </tr>
                                    @endforeach
                                    <tr style="font-size:10px;font-weight:bold;">
                                        <td style="border:1px solid black">TOTAL</td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_c'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_d'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_e'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_f'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_g'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_h'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_i'))}}
                                        </td>
                                        <td style="border:1px solid black;text-align:right">
                                            {{number_format($item->detail()->sum('kolom_j'))}}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                {{-- <div class="col-12 d-flex align-items-center gap-2">
                                    <form method="post" action="/admin/ikpa/deviasi/{{$item->id}}"
                                        enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <input type="file" name="file" class="form-control">
                                        <button type="submit" class="btn btn-primary">Import Data</button>
                                    </form>
                                </div> --}}

                                <a href="/admin/ikpa/deviasi/edit/{{$item->id}}" class="btn btn-sm btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="/admin/ikpa/deviasi/delete/{{$item->id}}" class="btn btn-sm btn-danger"
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