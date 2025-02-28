@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table width="100%" cellpadding="5">
                    <tr>
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight:bold"
                            width="10%">SKPD
                        </td>
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
                Note : * Anda hanya bisa melihat dan mengajukan keberatan atas data revisi DPA yang di input oleh
                BPKPAD<br />

                <a href="#" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-default">Ajukan
                    Keberatan</a>

                <ul>
                    @if ($data->keberatan->count() != 0)
                    List Keberatan : <br />
                    @foreach ($data->keberatan as $item)

                    <li> <a href="/admin/ikpa/revisi/keberatan/delete/{{$item->id}}"
                            onclick="return confirm('Yakin ingin di hapus?');"><i class="fa fa-times"></i></a>
                        &nbsp;&nbsp;{{$item->isi}}</li>
                    @endforeach

                    @endif
                </ul>
            </div>
        </div>

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
                        @foreach ($revisi as $key => $item)
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
                            <td style="border: 1px solid black; text-align:right">{{number_format($item->pagu_awal)}}
                            </td>
                            <td style="border: 1px solid black; text-align:right">{{number_format($item->pagu_akhir)}}
                            </td>
                            <td style="border: 1px solid black;">{{$item->pp}}</td>
                            <td style="border: 1px solid black;">{{$item->top}}</td>

                        </tr>
                        @endforeach
                    </tbody>


                </table>
                <br /><br />
                <table class="table table-sm" style="border: 1px solid black; text-align:center">
                    <thead>
                        <tr style="font-size:12px" class="bg-warning" style="border: 1px solid black">
                            <th style="border: 1px solid black">Jumlah Revisi</th>
                            <th style="border: 1px solid black">NKRA Semester {{$data->semester}}</th>
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
                </table>
                <br />
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Ajukan Keberatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form method="post" action="/admin/ikpa/revisi/keberatan/{{$data->id}}">
                @csrf
                <div class="modal-body">
                    <textarea class="form-control" rows="3" placeholder="isi" name="isi"></textarea>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class=" btn btn-primary"><i class="fa fa-paper-plane"></i>
                        Kirim</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection