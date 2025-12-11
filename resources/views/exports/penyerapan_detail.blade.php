<table>
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">BULAN</th>
            <th colspan="4">RAK Tahunan</th>
            <th colspan="4">Realisasi RAK</th>
            <th colspan="5">RAK (Rupiah) Kumulatif</th>
            <th colspan="5">Realisasi RAK (Rupiah) Kumulatif</th>
            <th rowspan="2">Penyerapan Anggaran</th>
        </tr>
        <tr>
            <th>51</th>
            <th>52</th>
            <th>53</th>
            <th>54</th>
            <th>51</th>
            <th>52</th>
            <th>53</th>
            <th>54</th>
            <th>51</th>
            <th>52</th>
            <th>53</th>
            <th>54</th>
            <th>Komulatif RAK KB</th>
            <th>51</th>
            <th>52</th>
            <th>53</th>
            <th>54</th>
            <th>Kumulatif Realisasi RAK</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->detail as $key => $item2)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item2->bulan }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_c, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_d, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_e, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_f, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_g, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_h, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_i, 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($item2->kolom_j, 0, ',', '.') }}</td>
            <td></td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_komulatif_51'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_komulatif_52'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_komulatif_53'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_komulatif_54'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_komulatif_kb'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_realisasi_51'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_realisasi_52'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_realisasi_53'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_realisasi_54'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['rak_realisasi_kb'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($cumulativeData[$item2->id]['penyerapan_anggaran'], 2) }} %</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2">JUMLAH</td>
            <td style="text-align:right">{{ number_format($totals['kolom_c'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_d'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_e'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_f'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_g'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_h'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_i'], 0, ',', '.') }}</td>
            <td style="text-align:right">{{ number_format($totals['kolom_j'], 0, ',', '.') }}</td>
            <td colspan="10"></td>
        </tr>
    </tbody>
</table>
