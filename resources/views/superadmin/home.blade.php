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
    </div>
</div>
@endsection