@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
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

                </table>
                <br />

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <div class="col-md-12">
        <h2>Capaian DPA</h2>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">

                <table width="100%" cellpadding="5">
                    <tr class="bg-warning" style="font-size:10px;font-weight:bold;text-align:center">
                        <td style="border:1px solid black">NO</td>
                        <td style="border:1px solid black; min-width:110px;">SKPD</td>
                        <td style="border:1px solid black">Kode</td>
                        <td style="border:1px solid black">Program</td>
                        <td style="border:1px solid black">Kegiatan</td>
                        <td style="border:1px solid black">Subkegiatan</td>
                        <td style="border:1px solid black">Volumen Sub. Kegiatan DPA Dalam Setahun</td>
                        <td style="border:1px solid black">Satuan</td>
                        <td style="border:1px solid black">Target Volume Sub Kegiatan TW I</td>
                        <td style="border:1px solid black">Target Volume Sub Kegiatan TW II</td>
                        <td style="border:1px solid black">Target Volume Sub Kegiatan TW III</td>
                        <td style="border:1px solid black">Target Volume Sub Kegiatan TW IV</td>
                        <td style="border:1px solid black">Realisasi Pencapaian SubKegiatan di TW I</td>
                        <td style="border:1px solid black">Realisasi Pencapaian SubKegiatan di TW II</td>
                        <td style="border:1px solid black">Realisasi Pencapaian SubKegiatan di TW III</td>
                        <td style="border:1px solid black">Realisasi Pencapaian SubKegiatan di TW IV</td>


                    </tr>
                    <tr class="bg-warning" style="font-size:8px;font-weight:bold;text-align:center">
                        <td style="border:1px solid black; min-width:110px;"></td>
                        <td style="border:1px solid black; min-width:110px;">(a)</td>
                        <td style="border:1px solid black; min-width:110px;">(b)</td>
                        <td style="border:1px solid black; min-width:110px;">(c)</td>
                        <td style="border:1px solid black; min-width:110px;">(d)</td>
                        <td style="border:1px solid black; min-width:110px;">(e)</td>
                        <td style="border:1px solid black; min-width:110px;">(f)</td>
                        <td style="border:1px solid black; min-width:110px;">(g)</td>
                        <td style="border:1px solid black; min-width:110px;">(h)</td>
                        <td style="border:1px solid black; min-width:110px;">(i)</td>
                        <td style="border:1px solid black; min-width:110px;">(j)</td>
                        <td style="border:1px solid black; min-width:110px;">(k)</td>
                        <td style="border:1px solid black; min-width:110px;">(l)</td>
                        <td style="border:1px solid black; min-width:110px;">(m)</td>
                        <td style="border:1px solid black; min-width:110px;">(n)</td>
                        <td style="border:1px solid black; min-width:110px;">(o)</td>
                    </tr>
                    @foreach ($data->detail as $key=> $item2)
                    <tr style="font-size:10px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style=" border:1px solid black">{{$key + 1}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_a}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_b}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_c}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_d}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_e}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_f}}</td>
                        <td style=" border:1px solid black">{{$item2->kolom_g}}</td>

                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_h)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_i)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_j)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_k)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_l)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_m)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_n)}}</td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->kolom_o)}}</td>



                    </tr>
                    @endforeach

                </table>

            </div>
        </div>
    </div>
</div>
@endsection