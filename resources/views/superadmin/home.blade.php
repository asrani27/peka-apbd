@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 text-center">
        <img src="/logo/bpkpad.png" width="15%">
        <h2>PEKA ABPD KOTA BANJARMASIN</h2>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">

                <a href="/superadmin/ikpa" class="btn btn-app text-bold" style="box-shadow: 1px 2px 2px black;">
                    <i class="fas fa-edit"></i> Perhitungan IKPA
                </a>
                <a href="/superadmin/skpd" class="btn btn-app text-bold" style="box-shadow: 1px 2px 2px black;">
                    <i class="fas fa-inbox"></i> Data SKPD
                </a>

            </div>
        </div>
        <div class="card">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
</div>
@endsection

@push('js')

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    let skpd = @json($skpd);
    console.log(skpd);

    skpd = skpd.map(item => ({
        label: item.label, // Nama SKPD tetap sebagai label di sumbu X
        y: item.y, // Nilai capaian
        indexLabel: item.y + "%", // Menampilkan nilai Y di atas batang
        indexLabelFontWeight: "bold", // Buat teks lebih tebal
        indexLabelFontSize: 14, // Ukuran font lebih besar agar mudah dibaca
        indexLabelFontColor: "black" // Warna teks hitam agar kontras
    }));

    window.onload = function () {
    
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "CAPAIAN PER SKPD"
        },
        axisY: {
            title: "Capaian",
            suffix: "%"
        },
        axisX: {
            title: "SKPD",
            labelFormatter: function() { return ""; } 
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.0#"%"",
            dataPoints: skpd
        }]
    });
    chart.render();
    
    }
</script>
@endpush