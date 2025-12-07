@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('error') }}
</div>
@endif

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
                        <td style="border: 1px solid black; background-color:antiquewhite; font-weight-bold">TAHUN</td>
                        <td style="border: 1px solid black;">: {{$data->tahun}}</td>
                    </tr>

                </table>
                <div class="mt-3">
                    <a href="{{ route('capaian.edit', $data->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit Capaian
                    </a>
                </div>
                <br />

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>


    <!-- Ketepatan Waktu Table -->
    <div class="col-md-12">
        <h3>Ketepatan Waktu Pelaporan Capaian Output SKPD</h3>
        <div class="card">
            <div class="card-body table-responsive">
                <table width="50%" cellpadding="5">
                    <!-- Header Row -->
                    <tr>
                        <td style="border:1px solid black; background-color:#FFFACD; text-align:center; font-size:11px;font-weight:bold;"
                            width="25%">Periode</td>
                        <td style="border:1px solid black; background-color:#FFFACD; text-align:center; font-size:11px;font-weight:bold;"
                            width="75%">Ketepatan Waktu Pelaporan Capaian Output SKPD (Ya/Tidak)</td>
                    </tr>
                    <!-- Data Rows -->
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">TW 1</td>
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">
                            {{$data->periode_tw1 ?? '-'}}</td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">TW 2</td>
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">
                            {{$data->periode_tw2 ?? '-'}}</td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">TW 3</td>
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">
                            {{$data->periode_tw3 ?? '-'}}</td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">TW 4</td>
                        <td style="border:1px solid black;text-align:center; background-color:#F0F8FF;">
                            {{$data->periode_tw4 ?? '-'}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <h2>Capaian DPA</h2>

        <!-- Import Excel Form -->
        <div class="card mb-3">
            <div class="card-header bg-warning">
                <h5><i class="fas fa-exclamation-triangle"></i> Import Data Detail (Mulai dari Baris 7)</h5>
                <small class="text-muted"><strong>Perhatian:</strong> Data lama akan dihapus sebelum import data
                    baru!</small>
            </div>
            <div class="card-body">
                <form action="/superadmin/ikpa/capaian/detail/{{ $data->id }}/import" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="file">Pilih File Excel (.xlsx, .xls, .csv)</label>
                                <input type="file" name="file" id="file" class="form-control" required
                                    accept=".xlsx,.xls,.csv">
                                <small class="form-text text-muted">
                                    Pastikan data dimulai dari baris 7<br>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-file-excel"></i> Import Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive">

                <table width="100%" cellpadding="5">
                    <tr class="bg-warning" style="font-size:10px;font-weight:bold;text-align:center">
                        <td style="border:1px solid black">NO</td>
                        <td style="border:1px solid black">Kode</td>
                        <td style="border:1px solid black">Program</td>
                        <td style="border:1px solid black; min-width:200px;">Kegiatan</td>
                        <td style="border:1px solid black; min-width:250px;">Subkegiatan</td>
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
                        <td style="border:1px solid black">Persentase Target Volume TW I</td>
                        <td style="border:1px solid black">Persentase Target Volume TW II</td>
                        <td style="border:1px solid black">Persentase Target Volume TW III</td>
                        <td style="border:1px solid black">Persentase Target Volume TW IV</td>
                        <td style="border:1px solid black">Persentase Capaian Volume TW I</td>
                        <td style="border:1px solid black">Persentase Capaian Volume TW II</td>
                        <td style="border:1px solid black">Persentase Capaian Volume TW III</td>
                        <td style="border:1px solid black">Persentase Capaian Volume TW IV</td>
                        <td style="border:1px solid black">Nilai Capaian TW I</td>
                        <td style="border:1px solid black">Nilai Capaian TW II</td>
                        <td style="border:1px solid black">Nilai Capaian TW III</td>
                        <td style="border:1px solid black">Nilai Capaian TW IV</td>
                        <td style="border:1px solid black">Nilai Capaian Maksimal TW I</td>
                        <td style="border:1px solid black">Nilai Capaian Maksimal TW II</td>
                        <td style="border:1px solid black">Nilai Capaian Maksimal TW III</td>
                        <td style="border:1px solid black">Nilai Capaian Maksimal TW IV</td>


                    </tr>
                    <tr class="bg-warning" style="font-size:8px;font-weight:bold;text-align:center">
                        <td style="border:1px solid black; min-width:110px;"></td>
                        <td style="border:1px solid black; min-width:110px;">(b)</td>
                        <td style="border:1px solid black; min-width:110px;">(c)</td>
                        <td style="border:1px solid black; min-width:110px;">(d)</td>
                        <td style="border:1px solid black; min-width:200px;">(e)</td>
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
                        <td style="border:1px solid black; min-width:110px;">(p)</td>
                        <td style="border:1px solid black; min-width:110px;">(q)</td>
                        <td style="border:1px solid black; min-width:110px;">(r)</td>
                        <td style="border:1px solid black; min-width:110px;">(s)</td>
                        <td style="border:1px solid black; min-width:110px;">(t)</td>
                        <td style="border:1px solid black; min-width:110px;">(u)</td>
                        <td style="border:1px solid black; min-width:110px;">(v)</td>
                        <td style="border:1px solid black; min-width:110px;">(w)</td>
                        <td style="border:1px solid black; min-width:110px;">(x)</td>
                        <td style="border:1px solid black; min-width:110px;">(y)</td>
                        <td style="border:1px solid black; min-width:110px;">(z)</td>
                        <td style="border:1px solid black; min-width:110px;">(aa)</td>
                        <td style="border:1px solid black; min-width:110px;">(ab)</td>
                        <td style="border:1px solid black; min-width:110px;">(ac)</td>
                        <td style="border:1px solid black; min-width:110px;">(ad)</td>
                        <td style="border:1px solid black; min-width:110px;">(ae)</td>
                    </tr>
                    @foreach ($data->detail as $key=> $item2)
                    <tr style="font-size:10px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style=" border:1px solid black">{{$key + 1}}</td>
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
                        <td style=" border:1px solid black;text-align:right; background-color:#E6E6FA;">
                            {{$item2->persentase_target_tw1_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#E6E6FA;">
                            {{$item2->persentase_target_tw2_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#E6E6FA;">
                            {{$item2->persentase_target_tw3_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#E6E6FA;">
                            {{$item2->persentase_target_tw4_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFFFE0;">
                            {{$item2->persentase_capaian_tw1_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFFFE0;">
                            {{$item2->persentase_capaian_tw2_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFFFE0;">
                            {{$item2->persentase_capaian_tw3_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFFFE0;">
                            {{$item2->persentase_capaian_tw4_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#90EE90;">
                            {{$item2->nilai_capaian_tw1_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#90EE90;">
                            {{$item2->nilai_capaian_tw2_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#90EE90;">
                            {{$item2->nilai_capaian_tw3_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#90EE90;">
                            {{$item2->nilai_capaian_tw4_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFB6C1;">
                            {{$item2->nilai_capaian_maksimal_tw1_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFB6C1;">
                            {{$item2->nilai_capaian_maksimal_tw2_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFB6C1;">
                            {{$item2->nilai_capaian_maksimal_tw3_formatted}}</td>
                        <td style=" border:1px solid black;text-align:right; background-color:#FFB6C1;">
                            {{$item2->nilai_capaian_maksimal_tw4_formatted}}</td>



                    </tr>
                    @endforeach

                </table>

            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="col-md-12">
        <h3>Ringkasan Capaian per Triwulan</h3>
        <div class="card">
            <div class="card-body table-responsive">
                @php
                $summary = $data->getSummaryData();
                @endphp
                <table width="100%" cellpadding="5">
                    <!-- Header Row -->
                    <tr>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH CAPAIAN TRIWULAN 1</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH CAPAIAN TRIWULAN 2</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH CAPAIAN TRIWULAN 3</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH CAPAIAN TRIWULAN 4</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH OUTPUT TRIWULAN 1</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH OUTPUT TRIWULAN 2</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH OUTPUT TRIWULAN 3</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">JUMLAH OUTPUT TRIWULAN 4</td>
                    </tr>
                    <!-- Data Row -->
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['total_capaian_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['total_capaian_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['total_capaian_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['total_capaian_tw4'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['count_output_tw1'], 0)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['count_output_tw2'], 0)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['count_output_tw3'], 0)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['count_output_tw4'], 0)}}
                        </td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">RATA-RATA NILAI CAPAIAN OUTPUT TRIWULAN 1</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">RATA-RATA NILAI CAPAIAN OUTPUT TRIWULAN 2</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">RATA-RATA NILAI CAPAIAN OUTPUT TRIWULAN 3</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">RATA-RATA NILAI CAPAIAN OUTPUT TRIWULAN 4</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">KOEFISIEN PENYESUAIAN TRIWULAN 1</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">KOEFISIEN PENYESUAIAN TRIWULAN 2</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">KOEFISIEN PENYESUAIAN TRIWULAN 3</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight:bold;"
                            width="12.5%">KOEFISIEN PENYESUAIAN TRIWULAN 4</td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_tw4'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['koefisien_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['koefisien_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['koefisien_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['koefisien_tw4'], 2)}}
                        </td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Rata-Rata Capaian Disesuaikan Tw1</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Rata-Rata Capaian Disesuaikan Tw2</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight:bold;"
                            width="12.5%">Rata-Rata Capaian Disesuaikan Tw3</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Rata-Rata Capaian Disesuaikan Tw4</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Nilai Ketepatan Waktu Tw1</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Nilai Ketepatan Waktu Tw2</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="12.5%">Nilai Ketepatan Waktu Tw3</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight:bold;"
                            width="12.5%">Nilai Ketepatan Waktu Tw4</td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_disesuaikan_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_disesuaikan_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_disesuaikan_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['rata_rata_disesuaikan_tw4'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_tw4'], 2)}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Bobot Table -->
    <div class="col-md-12">
        <h3>Bobot Penilaian IKPA</h3>
        <div class="card">
            <div class="card-body table-responsive">
                <table width="50%" cellpadding="5">
                    <!-- Header Row -->
                    <tr>
                        <td style="border:1px solid black; background-color:#FFD700; text-align:center; font-size:11px;font-weight:bold;"
                            width="33.33%">Bobot Nilai Triwulanan</td>
                        <td style="border:1px solid black; background-color:#98FB98; text-align:center; font-size:11px;font-weight-bold;"
                            width="33.33%">Bobot Nilai Capaian Output</td>
                        <td style="border:1px solid black; background-color:#87CEEB; text-align:center; font-size:11px;font-weight-bold;"
                            width="33.33%">Bobot Nilai Ketepatan Waktu</td>
                    </tr>
                    <!-- Data Row -->
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:right; background-color:#FFFACD;">
                            {{number_format(($data->bobot_triwulan ?? 0) * 100, 2)}}%
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#F0FFF0;">
                            {{number_format(($data->bobot_capaian ?? 0) * 100, 2)}}%
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#F0FFFF;">
                            {{number_format(($data->bobot_ketepatan ?? 0) * 100, 2)}}%
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Nilai IKPA Table -->
    <div class="col-md-12">
        <h3>Nilai IKPA per Triwulan</h3>
        <div class="card">
            <div class="card-body table-responsive">
                <table width="50%" cellpadding="5">
                    <!-- Header Row -->
                    <tr>
                        <td style="border:1px solid black; background-color:#F0E68C; text-align:center; font-size:11px;font-weight:bold;"
                            width="16.67%">Triwulan</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="41.67%">Nilai Capaian Output</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight-bold;"
                            width="41.67%">Nilai Ketepatan Waktu</td>
                    </tr>
                    <!-- Data Rows -->
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F8F8FF;">1</td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['nilai_capaian_output_tw1'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_output_tw1'], 2)}}
                        </td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F8F8FF;">2</td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['nilai_capaian_output_tw2'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_output_tw2'], 2)}}
                        </td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F8F8FF;">3</td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['nilai_capaian_output_tw3'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_output_tw3'], 2)}}
                        </td>
                    </tr>
                    <tr style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#F8F8FF;">4</td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary['nilai_capaian_output_tw4'], 2)}}
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary['nilai_ketepatan_waktu_output_tw4'], 2)}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Skor Indikator Tertimbang Table -->
    <div class="col-md-12">
        <h3>Skor Indikator Tertimbang per Triwulan</h3>
        <div class="card">
            <div class="card-body table-responsive">
                <table width="80%" cellpadding="5">
                    <!-- Header Row -->
                    <tr>
                        <td style="border:1px solid black; background-color:#FFE4B5; text-align:center; font-size:11px;font-weight:bold;"
                            width="16.67%">Triwulan</td>
                        <td style="border:1px solid black; background-color:#E8F5E8; text-align:center; font-size:11px;font-weight-bold;"
                            width="26.67%">Capaian Output (VLOOKUP)</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight:bold;"
                            width="26.67%">Capaian Waktu (VLOOKUP)</td>
                        <td style="border:1px solid black; background-color:#F0E68C; text-align:center; font-size:11px;font-weight-bold;"
                            width="15%">Capaian Output tertimbang Final<br><small>(R×O + S×P)</small></td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight:bold;"
                            width="26.67%">Bobot</td>
                        <td style="border:1px solid black; background-color:#E6F3FF; text-align:center; font-size:11px;font-weight:bold;"
                            width="26.67%">Skor Indikator Tertimbang </td>
                    </tr>
                    <!-- Data Rows -->
                    @for ($i = 1; $i <= 4; $i++) <tr
                        style="font-size:11px;font-weight:bold; font-family: 'Roboto Mono', monospace;">
                        <td style="border:1px solid black;text-align:center; background-color:#FFF8DC;">{{$i}}</td>
                        <td style="border:1px solid black;text-align:right; background-color:#E8F5E8;">
                            {{number_format($summary["nilai_capaian_output_tw{$i}"], 2)}}

                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            {{number_format($summary["nilai_ketepatan_waktu_output_tw{$i}"], 2)}}

                        </td>
                        <td style="border:1px solid black;text-align:center; background-color:#F0E68C;">
                            <strong>{{$data->getFormattedSkorIndikatorTertimbang($i)}}</strong>
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">
                            35 %
                        </td>
                        <td style="border:1px solid black;text-align:right; background-color:#E6F3FF;">

                            <strong>{{$data->getFormattedSkorIndikatorTertimbangDenganBobot($i)}}</strong>
                        </td>
                        </tr>
                        @endfor
                </table>
            </div>
        </div>
    </div>
</div>
@endsection