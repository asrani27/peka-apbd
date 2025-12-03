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
                <a href="/superadmin/ikpa/deviasi/detail/{{$data->skpd->kode}}/{{$data->tahun}}/tarikdata"
                    class="btn btn-primary"><i class="fa fa-sync"></i> Tarik Data Kenangan</a>

                @php
                $septemberData = $data->detail->where('bulan', 'September')->first();
                @endphp

                @if($septemberData)
                <div class="mt-3">
                    <div class="alert alert-info">
                        <strong>Nilai IKPA September:</strong>

                        <span class="float-right font-weight-bold">{{ number_format($septemberData->nilai_ikpa, 2) }} / {{ number_format($septemberData->nilai_ikpa * 0.2, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <div class="col-md-12">
        <h2>Deviasi DPA</h2>
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
                        <td colspan="5" style="border:1px solid black">Proporsi Pagu*</td>

                        <td colspan="4" style="border:1px solid black">Deviasi*</td>
                        <td colspan="4" style="border:1px solid black">Koreksi Deviasi Maksimal 100%</td>
                        <td colspan="4" style="border:1px solid black">Deviasi Tertimbang***</td>
                        <td rowspan="2" style="border:1px solid black; min-width:110px;">Deviasi Seluruh KB</td>
                        <td rowspan="2" style="border:1px solid black; min-width:110px;">Akumulatif Deviasi Seluruh KB
                        </td>
                        <td rowspan="2" style="border:1px solid black; min-width:110px;">Dev DIPAn Rata-Rata per Bulan
                            (dalam nilai
                            absolut)</td>
                        <td rowspan="2" style="border:1px solid black; min-width:110px;">Nilai IKPA (Interval 15%)</td>


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
                        <td style="border:1px solid black; min-width:110px;">TOTAL</td>
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
                    </tr>
                    @foreach ($data->detail as $key=> $item2)
                    <tr style="font-size:10px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
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
                            {{number_format($data->proporsiPaguRAK51(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK52(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK53(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK54(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($data->totalProporsiPagu(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasi51(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasi52(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasi53(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasi54(),2)}} %
                        </td>

                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->koreksi51(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->koreksi52(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->koreksi53(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->koreksi54(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasiTertimbang51(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasiTertimbang52(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasiTertimbang53(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasiTertimbang54(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->seluruhDeviasi(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->akumulasiDeviasi(),2)}} %
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->deviasiRataRata(),2)}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($item2->nilai_ikpa,2)}}
                        </td>


                    </tr>
                    @endforeach
                    <tr style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;"">

                        <td style=" border:1px solid black" colspan="2">JUMLAH</td>
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

                    <tr style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;"">
                        <td style=" border:1px solid black" colspan="2">TOTAL PAGU</td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->totalPagu())}}
                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                    </tr>
                    <tr style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;"">
                        <td style=" border:1px solid black" colspan="2">*Proporsi pagu berdasarkan kelompok belanja
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK51(),2)}} %
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK52(),2)}} %
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK53(),2)}} %
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($data->proporsiPaguRAK54(),2)}} %
                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

                        </td>
                        <td style="border:1px solid black;text-align:right">

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
