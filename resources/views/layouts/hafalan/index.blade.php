@extends('layouts.Master')
@section('title'){{ 'Data Hafalan' }}@endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"> Data Hafalan</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Data Hafalan</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                          Input Hafalan
                        </button>

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
<!-- Modal -->
<div class="modal fade" id="basicModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Input Hafalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="teacher_id" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Pilih Siswa</label>
                        <select class="form-control" name="student_id" id="select2" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="LembarHafalan" class="form-label">Lembar Hafalan</label>
                            <input type="number" id="LembarHafalan" class="form-control" required />
                        </div>
                        <div class="col mb-0">
                            <label for="Ayat" class="form-label">Ayat</label>
                            <input type="number" id="Ayat" class="form-control" required  />
                        </div>
                        <div class="col mb-0">
                            <label for="Juz" class="form-label">Juz</label>
                            <input type="number" id="Juz" class="form-control" required />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="InputSuara" class="form-label">Suara</label>
                            <input type="file" id="audioFile" class="form-control"  />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="btn btn-primary">Simpan Hafalan</button>
                </div>
            </form>
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


