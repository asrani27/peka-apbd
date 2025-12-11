<table>
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">BULAN</th>
            <th colspan="4">RAK Tahunan</th>
            <th colspan="4">Realisasi RAK</th>
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
        </tr>
        <tr>
            <td colspan="2">TOTAL PAGU</td>
            <td style="text-align:right">{{ number_format($totalPagu, 0, ',', '.') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">*Proporsi pagu berdasarkan kelompok belanja</td>
            <td>{{ number_format($proporsiPagu['RAK51'], 2) }} %</td>
            <td>{{ number_format($proporsiPagu['RAK52'], 2) }} %</td>
            <td>{{ number_format($proporsiPagu['RAK53'], 2) }} %</td>
            <td>{{ number_format($proporsiPagu['RAK54'], 2) }} %</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
