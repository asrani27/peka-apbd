@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data SKPD</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table class="table table-hover text-nowrap table-sm">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skpd as $key => $item)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$item->kode}}</td>
                            <td>{{$item->nama}}</td>
                            <td>
                                <a href="/superadmin/skpd/edit/{{$item->id}}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-edit"> Edit </i></a>
                                
                                @if ($item->user == null)
                                <a href="/superadmin/skpd/createuser/{{$item->id}}" class="btn btn-sm btn-warning"><i
                                        class="fa fa-key"> Create User </i></a>
                                @else
                                <a href="/superadmin/skpd/resetpass/{{$item->id}}" class="btn btn-sm btn-success"><i
                                        class="fa fa-lock"> Reset Pass </i></a>

                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
