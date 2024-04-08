@extends('layouts.Master')
@section('title'){{ 'Data siswa' }}@endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"> Data Pengguna</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Data Pengguna</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('user-create') }}"  class="btn btn-primary">Tambah Pengguna</a>

                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="table">
                          <thead>
                            <tr class="text-nowrap">
                              <th>#</th>
                              <th>Nama</th>
                              <th>Alamat</th>
                              <th>Tangal Lahir</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
       var table =  $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user-data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { data: 'name', name: 'name' },
                { data: 'alamat', name: 'alamat' },
                { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                { data: 'aksi', name: 'aksi' }
            ]
        });
    });
</script>


@endpush
