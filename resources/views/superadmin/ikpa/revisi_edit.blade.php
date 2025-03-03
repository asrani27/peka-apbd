@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <table width="100%" cellpadding="5">
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold"
                            width="10%">SKPD</td>
                        <td style="border: 1px solid black;">: {{$data->skpd->nama}}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold">TAHUN</td>
                        <td style="border: 1px solid black;">: {{$data->tahun}}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold">SEMESTER
                        </td>
                        <td style="border: 1px solid black;">: {{$data->semester}}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold">TRIWULAN
                        </td>
                        <td style="border: 1px solid black;">: {{$data->triwulan}}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold">BULAN</td>
                        <td style="border: 1px solid black;">: {{$data->bulan}}</td>
                    </tr>
                </table>
                <br />
                <ul>
                    @if ($data->keberatan->count() != 0)
                    Keberatan telah di ajukan : <br />
                    @foreach ($data->keberatan as $item)

                    <li> {{$item->isi}}</li>
                    @endforeach

                    @endif
                </ul>

                {{-- <table class="table table-sm" style="border: 1px solid black; text-align:center">
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black">Jumlah Revisi Sem 1</th>
                            <th style="border: 1px solid black">NKRA Semester 1</th>
                            <th style="border: 1px solid black">NKRA Tahunan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                            <td style="border: 1px solid black">{{$jml_revisi}}</td>
                            <td style="border: 1px solid black">{{$nkra_semester}}</td>
                            <td style="border: 1px solid black">{{$nkra_tahunan}}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black">Jumlah Revisi Sem 2</th>
                            <th style="border: 1px solid black">NKRA Semester 2</th>
                            <th style="border: 1px solid black">NKRA Tahunan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                            <td style="border: 1px solid black">{{$jml_revisi}}</td>
                            <td style="border: 1px solid black">{{$nkra_semester}}</td>
                            <td style="border: 1px solid black">{{$nkra_tahunan}}</td>
                        </tr>
                    </tbody>
                </table>
                <br />
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
                            <td style="border: 1px solid black">{{$skor}}</td>
                            <td style="border: 1px solid black">{{$bobot_revisi * 100}} %</td>
                            <td style="border: 1px solid black">{{$sit}}</td>
                        </tr>
                    </tbody>
                </table> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <div class="col-md-12">
        <h2>Revisi DPA</h2>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-sm" style="border: 1px solid black; text-align:center">
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black" rowspan="2">No</th>
                            <th style="border: 1px solid black">Tanggal Nota Dinas Pergeseran DPA oleh SKPD*</th>
                            <th style="border: 1px solid black">Tanggal Pengesahan oleh BPKPAD*</th>
                            <th style="border: 1px solid black">Revisi Ke</th>
                            <th style="border: 1px solid black">Jenis Revisi</th>
                            <th style="border: 1px solid black">Pagu Awal</th>
                            <th style="border: 1px solid black">Pagu Akhir</th>
                            <th style="border: 1px solid black">Perubahan Pagu</th>
                            <th style="border: 1px solid black">Termasuk Objek Perhitungan</th>
                            <th style="border: 1px solid black" rowspan="2" colspan="2"></th>
                        </tr>
                        <tr style="font-size:10px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black">semester {{$data->semester}}</th>
                            <th style="border: 1px solid black">(a)</th>
                            <th style="border: 1px solid black">(b)</th>
                            <th style="border: 1px solid black">(c)</th>
                            <th style="border: 1px solid black">(d)</th>
                            <th style="border: 1px solid black">(e)</th>
                            <th style="border: 1px solid black">(f)</th>
                            <th style="border: 1px solid black">(g)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revisi->where('semester',1) as $key => $item)
                        @if ($revisi_id == $item->id)
                        <form method="post" action="/superadmin/ikpa/revisi/{{$data->id}}/edit/{{$revisi_id}}">
                            @csrf
                            <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                <td style="border: 1px solid black">{{$key + 1}}</td>
                                <td style="border: 1px solid black">
                                    <input type="date" name="tanggal_nodin" value="{{$item->tanggal_nodin}}">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="date" name="tanggal_pengesahan" value="{{$item->tanggal_pengesahan}}">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="revisi_ke" value="{{$item->revisi_ke}}" required>
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="jenis_revisi" value="{{$item->jenis_revisi}}" required>
                                </td>
                                <td style="border: 1px solid black; text-align:right">
                                    <input type="text" name="pagu_awal" value="{{$item->pagu_awal}}" required>
                                </td>
                                <td style="border: 1px solid black; text-align:right">
                                    <input type="text" name="pagu_akhir" value="{{$item->pagu_akhir}}" required>
                                </td>
                                <td style="border: 1px solid black;">{{$item->pp}}</td>
                                <td style="border: 1px solid black;">{{$item->top}}</td>
                                <td style="border: 1px solid black;" colspan="2">
                                    <button type="submit" class="btn btn-primary btn-xs">
                                        update</button>
                                </td>
                            </tr>
                        </form>
                        @else

                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                            <td style="border: 1px solid black">{{$key + 1}}</td>
                            <td style="border: 1px solid black">
                                {{\Carbon\Carbon::parse($item->tanggal_nodin)->translatedFormat('d F Y')}}
                            </td>
                            <td style="border: 1px solid black">
                                {{\Carbon\Carbon::parse($item->tanggal_pengesahan)->translatedFormat('d F Y')}}
                            </td>
                            <td style="border: 1px solid black">{{$item->revisi_ke}}</td>
                            <td style="border: 1px solid black">{{$item->jenis_revisi}}</td>
                            <td style="border: 1px solid black; text-align:right">
                                {{number_format($item->pagu_awal)}}
                            </td>
                            <td style="border: 1px solid black; text-align:right">
                                {{number_format($item->pagu_akhir)}}
                            </td>
                            <td style="border: 1px solid black;">{{$item->pp}}</td>
                            <td style="border: 1px solid black;">{{$item->top}}</td>
                            <td style="border: 1px solid black;">
                                <a href="/superadmin/ikpa/revisi/{{$data->id}}/edit/{{$item->id}}"><i
                                        class="fa fa-edit"></i></a>
                            </td>

                            <td style="border: 1px solid black;">
                                <a href="/superadmin/ikpa/revisi/{{$data->id}}/delete/{{$item->id}}"
                                    onclick="return confirm('Yakin ingin dihapus?');" class="text-danger"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr style="font-size:10px" class="bg-warning" style="border: 1px solid black">
                            <th></th>
                            <th style="border: 1px solid black">semester 2</th>
                            <th style="border: 1px solid black">(a)</th>
                            <th style="border: 1px solid black">(b)</th>
                            <th style="border: 1px solid black">(c)</th>
                            <th style="border: 1px solid black">(d)</th>
                            <th style="border: 1px solid black">(e)</th>
                            <th style="border: 1px solid black">(f)</th>
                            <th style="border: 1px solid black">(g)</th>
                            <th colspan="2"></th>
                        </tr>
                        @foreach ($revisi->where('semester',2) as $key => $item)
                        @if ($revisi_id == $item->id)
                        <form method="post" action="/superadmin/ikpa/revisi/{{$data->id}}/edit/{{$revisi_id}}">
                            @csrf
                            <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                                <td style="border: 1px solid black">{{$key + 1}}</td>
                                <td style="border: 1px solid black">
                                    <input type="date" name="tanggal_nodin" value="{{$item->tanggal_nodin}}">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="date" name="tanggal_pengesahan" value="{{$item->tanggal_pengesahan}}">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="revisi_ke" value="{{$item->revisi_ke}}" required>
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="jenis_revisi" value="{{$item->jenis_revisi}}" required>
                                </td>
                                <td style="border: 1px solid black; text-align:right">
                                    <input type="text" name="pagu_awal" value="{{$item->pagu_awal}}" required>
                                </td>
                                <td style="border: 1px solid black; text-align:right">
                                    <input type="text" name="pagu_akhir" value="{{$item->pagu_akhir}}" required>
                                </td>
                                <td style="border: 1px solid black;">{{$item->pp}}</td>
                                <td style="border: 1px solid black;">{{$item->top}}</td>
                                <td style="border: 1px solid black;" colspan="2">
                                    <button type="submit" class="btn btn-primary btn-xs">
                                        update</button>
                                </td>
                            </tr>
                        </form>
                        @else

                        <tr style="background-color: rgb(234, 233, 231); font-size:12px">
                            <td style="border: 1px solid black">{{$key + 1}}</td>
                            <td style="border: 1px solid black">
                                {{\Carbon\Carbon::parse($item->tanggal_nodin)->translatedFormat('d F Y')}}
                            </td>
                            <td style="border: 1px solid black">
                                {{\Carbon\Carbon::parse($item->tanggal_pengesahan)->translatedFormat('d F Y')}}
                            </td>
                            <td style="border: 1px solid black">{{$item->revisi_ke}}</td>
                            <td style="border: 1px solid black">{{$item->jenis_revisi}}</td>
                            <td style="border: 1px solid black; text-align:right">
                                {{number_format($item->pagu_awal)}}
                            </td>
                            <td style="border: 1px solid black; text-align:right">
                                {{number_format($item->pagu_akhir)}}
                            </td>
                            <td style="border: 1px solid black;">{{$item->pp}}</td>
                            <td style="border: 1px solid black;">{{$item->top}}</td>
                            <td style="border: 1px solid black;">
                                <a href="/superadmin/ikpa/revisi/{{$data->id}}/edit/{{$item->id}}"><i
                                        class="fa fa-edit"></i></a>
                            </td>

                            <td style="border: 1px solid black;">
                                <a href="/superadmin/ikpa/revisi/{{$data->id}}/delete/{{$item->id}}"
                                    onclick="return confirm('Yakin ingin dihapus?');" class="text-danger"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        {{-- <tr>
                            <form method="post" action="/superadmin/ikpa/revisi/{{$data->id}}">
                                @csrf
                                <td style="border: 1px solid black"></td>
                                <td style="border: 1px solid black">
                                    <input type="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                        name="tanggal_nodin">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}"
                                        name="tanggal_pengesahan">
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="revisi_ke" required>
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="jenis_revisi" required>
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="pagu_awal" required
                                        onkeypress="return hanyaAngka(event)" />
                                </td>
                                <td style="border: 1px solid black">
                                    <input type="text" name="pagu_akhir" required
                                        onkeypress="return hanyaAngka(event)" />
                                </td>
                                <td style="border: 1px solid black" colspan="3">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                                        save / enter</button>
                                </td>

                            </form>
                        </tr> --}}
                    </tfoot>
                </table>
                <br />

            </div>
        </div>
    </div>
</div>
@endsection