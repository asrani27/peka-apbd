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
                <a href="/superadmin/ikpa/penyerapan/detail/{{$data->id}}/export-excel" 
                   class="btn btn-success"><i class="fa fa-file-excel"></i> Export Excel</a>
                <br />

                <div class="mt-3">
                    <div class="form-group">
                        <label for="bulanSelect"><strong>Pilih Bulan untuk Nilai Penyerapan Anggaran:</strong></label>
                        <select class="form-control" id="bulanSelect" style="width: 200px; display: inline-block;">
                            <option value="">- Pilih Bulan -</option>
                            @foreach($data->detail as $detail)
                            <option value="{{ $detail->bulan }}" {{ request('bulan')==$detail->bulan ? 'selected' : ''
                                }}>
                                {{ $detail->bulan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="nilaiPenyerapanContainer">
                        @php
                        $selectedBulan = request('bulan', '');
                        $selectedData = $data->detail->where('bulan', $selectedBulan)->first();
                        @endphp

                        @if($selectedData)
                        <div class="alert alert-info">
                            <strong>Nilai Penyerapan Anggaran {{ $selectedBulan }}:</strong>
                            <span class="float-right font-weight-bold">

                                {{number_format($cumulativeData[$selectedData->id]['penyerapan_anggaran'],2)}}
                                %
                            </span>

                        </div>
                        @elseif($selectedBulan === '')
                        <div class="alert alert-warning">
                            <strong>Silakan pilih bulan terlebih dahulu</strong>
                        </div>
                        @else
                        <div class="alert alert-warning">
                            <strong>Belum ada data untuk bulan {{ $selectedBulan }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

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
                            {{number_format($cumulativeData[$item2->id]['rak_komulatif_51'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_komulatif_52'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_komulatif_53'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_komulatif_54'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_komulatif_kb'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_realisasi_51'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_realisasi_52'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_realisasi_53'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_realisasi_54'])}}
                        </td>

                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['rak_realisasi_kb'])}}
                        </td>
                        <td style=" border:1px solid black;text-align:right">
                            {{number_format($cumulativeData[$item2->id]['penyerapan_anggaran'],2)}} %
                        </td>


                    </tr>
                    @endforeach
                    <tr style="font-size:12px;font-weight:bold;background-color:bisque; font-family: 'Roboto Mono', monospace;"">

                        <td style=" border:1px solid black" colspan="2">JUMLAH</td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_c'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_d'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_e'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_f'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_g'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_h'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_i'])}}
                        </td>
                        <td style="border:1px solid black;text-align:right">
                            {{number_format($totals['kolom_j'])}}
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

@push('js')
<script>
    $(document).ready(function() {
        // Store all detail data for dynamic access
        const detailData = @json($data->detail);
        const totalPagu = @json($data->totalPagu());
        
        // Handle bulan dropdown change
        $('#bulanSelect').on('change', function() {
            const selectedBulan = $(this).val();
            const container = $('#nilaiPenyerapanContainer');
            console.log(selectedBulan,container);
            if (!selectedBulan) {
                container.html(`
                    <div class="alert alert-warning">
                        <strong>Silakan pilih bulan terlebih dahulu</strong>
                    </div>
                `);
                return;
            }
            
            // Find data for selected month
            const selectedData = detailData.find(item => item.bulan === selectedBulan);
            
            if (selectedData) {
                // Calculate cumulative RAKRealisasiKB up to the selected month
                // Get all months up to and including the selected month
                const monthOrder = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const selectedMonthIndex = monthOrder.indexOf(selectedBulan);
                
                let cumulativeRealisasiKB = 0;
                
                // Sum up all realisasi values for months up to the selected month
                detailData.forEach(item => {
                    const itemMonthIndex = monthOrder.indexOf(item.bulan);
                    if (itemMonthIndex >= 0 && itemMonthIndex <= selectedMonthIndex) {
                        cumulativeRealisasiKB += parseFloat(item.kolom_g || 0) + 
                                              parseFloat(item.kolom_h || 0) + 
                                              parseFloat(item.kolom_i || 0) + 
                                              parseFloat(item.kolom_j || 0);
                    }
                });
                
                const penyerapanAnggaran = totalPagu > 0 ? (cumulativeRealisasiKB / totalPagu) * 100 : 0;
                
            console.log(penyerapanAnggaran,totalPagu,cumulativeRealisasiKB,selectedData);
                container.html(`
                    <div class="alert alert-info">
                        <strong>Nilai Penyerapan Anggaran ${selectedBulan}:</strong>
                        <span class="float-right font-weight-bold">
                            ${(penyerapanAnggaran * 0.30).toFixed(2)} %
                        </span>
                    </div>
                `);
            } else {
                container.html(`
                    <div class="alert alert-warning">
                        <strong>Belum ada data untuk bulan ${selectedBulan}</strong>
                    </div>
                `);
            }
        });
        
        // Trigger change on page load to display initial value
        if ($('#bulanSelect').val()) {
            $('#bulanSelect').trigger('change');
        }
    });
</script>
@endpush
