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
        <h2>Penyerapan Anggaran</h2>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">

                <table width="100%" cellpadding="5">
                    <tr class="bg-warning" style="font-size:14px;font-weight:bold;text-align:center">
                        <td rowspan="2" style="border:1px solid black">NO</td>
                        <td rowspan="2" style="border:1px solid black; min-width:110px;">BULAN</td>
                        <td colspan="4" style="border:1px solid black">RAK Tahunan</td>
                        <td colspan="4" style="border:1px solid black">Realisasi RAK</td>
                        <td rowspan="2" style="background-color: white"></td>
                        <td colspan="5" style="border:1px solid black">RAK (Rupiah) Kumulatif</td>

                        <td colspan="5" style="border:1px solid black">Realisasi RAK (Rupiah) Kumulatif</td>

                        <td rowspan="2" style="border:1px solid black; min-width:110px;">Penyerapan Anggaran</td>

                    </tr>
                    <tr class="bg-warning" style="font-size:12px;font-weight:bold;text-align:center">
                        <td style="border:1px solid black; min-width:110px;">51</td>
                        <td style="border:1px solid black; min-width:110px;">52</td>
                        <td style="border:1px solid black; min-width:110px;">53</td>
                        <td style="border:1px solid black; min-width:110px;">54</td>
                        <td style="border:1px solid black; min-width:110px;">51</td>
                        <td style="border:1px solid black; min-width:110px;">52</td>
                        <td style="border:1px solid black; min-width:110px;">53</td>
                        <td style="border:1px solid black; min-width:110px;">54</td>
                        <td style="border:1px solid black; min-width:110px;">51</td>
                        <td style="border:1px solid black; min-width:110px;">52</td>
                        <td style="border:1px solid black; min-width:110px;">53</td>
                        <td style="border:1px solid black; min-width:110px;">54</td>
                        <td style="border:1px solid black; min-width:110px;">Komulatif RAK KB</td>
                        <td style="border:1px solid black; min-width:110px;">51</td>
                        <td style="border:1px solid black; min-width:110px;">52</td>
                        <td style="border:1px solid black; min-width:110px;">53</td>
                        <td style="border:1px solid black; min-width:110px;">54</td>
                        <td style="border:1px solid black; min-width:110px;">Kumulatif Realisasi RAK</td>
                    </tr>
                    @foreach ($data->detail as $key=> $item2)
                    <tr style="font-size:15px;font-weight:bold;">
                        <td style=" border:1px solid black">{{$key + 1}}</td>
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

                        <td></td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKKomulatif51())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKKomulatif52())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKKomulatif53())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKKomulatif54())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKKomulatifKB())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKRealisasi51())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKRealisasi52())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKRealisasi53())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKRealisasi54())}}
                        </td>

                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->RAKRealisasiKB())}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->penyerapanAnggaran(),2)}} %
                        </td>


                    </tr>
                    @endforeach
                    <tr style="font-size:15px;font-weight:bold;background-color:bisque">

                        <td style="border:1px solid black" colspan="2">JUMLAH</td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_c'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_d'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_e'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_f'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_g'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_h'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_i'))}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->detail()->sum('kolom_j'))}}
                        </td>
                    </tr>

                </table>
                {{-- <br /><br />
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
                <br /> --}}
            </div>
        </div>
    </div>
</div>
@endsection