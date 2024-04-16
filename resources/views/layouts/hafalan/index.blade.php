@extends('layouts.Master')
@section('title'){{ 'Data siswa' }}@endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"> Data Hafalan</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Data Hafalan</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="#"  class="btn btn-primary">Hafalan </a>

                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="table">
                          <thead>
                            <tr class="text-nowrap">
                              <th>#</th>
                              <th>Nama Siswa</th>
                              <th>Lembar Hafalan</th>
                              <th>Ayat</th>
                              <th>Juz</th>
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
            ajax: "{{ route('hafalan-data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { data: 'nama_siswa', name: 'nama_siswa' },
                { data: 'lembar_hafalan', name: 'lembar_hafalan' },
                { data: 'ayat', name: 'ayat' },
                { data: 'juz', name: 'juz' },
            ]
        });
    });
</script>

@endpush


