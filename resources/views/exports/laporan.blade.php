<table>
    <thead>
        <tr>
            <th colspan="10" style="background-color: #FFC107; font-weight: bold; text-align: center; font-size: 14px;">
                LAPORAN RAK - {{ $skpd->nama }} - TAHUN {{ $tahun }}
            </th>
        </tr>
        <tr>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">NO</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">BULAN</th>
            <th colspan="4" style="background-color: #FFC107; font-weight: bold; text-align: center;">RAK Tahunan</th>
            <th colspan="4" style="background-color: #FFC107; font-weight: bold; text-align: center;">Realisasi RAK</th>
        </tr>
        <tr>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;"></th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;"></th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.1</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.2</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.3</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.4</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.1</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.2</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.3</th>
            <th style="background-color: #FFC107; font-weight: bold; text-align: center;">5.4</th>
        </tr>
    </thead>
    <tbody>
        @php
            $monthNames = [
                'januari', 'februari', 'maret', 'april', 'mei', 'juni',
                'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
            ];
            
            $monthDisplay = [
                'januari' => 'Januari', 'februari' => 'Februari', 'maret' => 'Maret',
                'april' => 'April', 'mei' => 'Mei', 'juni' => 'Juni',
                'juli' => 'Juli', 'agustus' => 'Agustus', 'september' => 'September',
                'oktober' => 'Oktober', 'november' => 'November', 'desember' => 'Desember'
            ];
            
            $filteredMonths = $semester == 1 ? 
                array_slice($monthNames, 0, 6) : 
                array_slice($monthNames, 6, 6);
            
            $no = 1;
            $total_rak_51 = 0;
            $total_rak_52 = 0;
            $total_rak_53 = 0;
            $total_rak_54 = 0;
            $total_real_51 = 0;
            $total_real_52 = 0;
            $total_real_53 = 0;
            $total_real_54 = 0;
        @endphp
        
        @foreach($filteredMonths as $month)
            @if(isset($rfkData[$month]))
                @php
                    $monthData = $rfkData[$month];
                    $rak_51 = $monthData['rencana']['5.1'] ?? 0;
                    $rak_52 = $monthData['rencana']['5.2'] ?? 0;
                    $rak_53 = $monthData['rencana']['5.3'] ?? 0;
                    $rak_54 = $monthData['rencana']['5.4'] ?? 0;
                    $real_51 = $monthData['realisasi']['5.1'] ?? 0;
                    $real_52 = $monthData['realisasi']['5.2'] ?? 0;
                    $real_53 = $monthData['realisasi']['5.3'] ?? 0;
                    $real_54 = $monthData['realisasi']['5.4'] ?? 0;
                    
                    $total_rak_51 += $rak_51;
                    $total_rak_52 += $rak_52;
                    $total_rak_53 += $rak_53;
                    $total_rak_54 += $rak_54;
                    $total_real_51 += $real_51;
                    $total_real_52 += $real_52;
                    $total_real_53 += $real_53;
                    $total_real_54 += $real_54;
                @endphp
                
                <tr>
                    <td style="font-weight: bold;">{{ $no }}</td>
                    <td>{{ $monthDisplay[$month] }}</td>
                    <td style="text-align: right;">{{ number_format($rak_51, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($rak_52, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($rak_53, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($rak_54, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($real_51, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($real_52, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($real_53, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($real_54, 0, ',', '.') }}</td>
                </tr>
                @php $no++; @endphp
            @endif
        @endforeach
        
        <tr style="background-color: bisque; font-weight: bold;">
            <td colspan="2">JUMLAH</td>
            <td style="text-align: right;">{{ number_format($total_rak_51, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_rak_52, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_rak_53, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_rak_54, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_real_51, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_real_52, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_real_53, 0, ',', '.') }}</td>
            <td style="text-align: right;">{{ number_format($total_real_54, 0, ',', '.') }}</td>
        </tr>
        
        <tr style="background-color: bisque; font-weight: bold;">
            <td colspan="2">TOTAL PAGU</td>
            <td style="text-align: right;">{{ number_format($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54, 0, ',', '.') }}</td>
            <td colspan="7"></td>
        </tr>
        
        @if(($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54) > 0)
        <tr style="background-color: bisque; font-weight: bold;">
            <td colspan="2">*Proporsi pagu berdasarkan kelompok belanja</td>
            <td style="text-align: right;">{{ number_format(($total_rak_51 / ($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54)) * 100, 2) }} %</td>
            <td style="text-align: right;">{{ number_format(($total_rak_52 / ($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54)) * 100, 2) }} %</td>
            <td style="text-align: right;">{{ number_format(($total_rak_53 / ($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54)) * 100, 2) }} %</td>
            <td style="text-align: right;">{{ number_format(($total_rak_54 / ($total_rak_51 + $total_rak_52 + $total_rak_53 + $total_rak_54)) * 100, 2) }} %</td>
            <td colspan="5"></td>
        </tr>
        @endif
    </tbody>
</table>
