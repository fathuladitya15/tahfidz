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
                              <th>Audio</th>
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
<!-- Modal Input -->
<div class="modal fade" id="basicModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Input Hafalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('hafalan-simpan') }}" id="inputHafalan" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="teacher_id" value="{{ Auth::user()->id }}">
                    <div class="row">
                        <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Pilih Siswa</label>
                        <select class="form-control" name="student_id" id="student_id" id="select2" required>
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
                            <input type="number" id="LembarHafalan" name="LembarHafalan" class="form-control" required />
                        </div>
                        <div class="col mb-0">
                            <label for="Ayat" class="form-label">Ayat</label>
                            <input type="number" id="Ayat" name="Ayat" class="form-control" required  />
                        </div>
                        <div class="col mb-0">
                            <label for="Juz" class="form-label">Juz</label>
                            <input type="number" id="Juz" name="Juz" class="form-control" required />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="InputSuara" class="form-label">Suara</label>
                            <input type="file" id="audioFile" name="audioFile" class="form-control"  />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan Hafalan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Play Audio -->
<div class="modal fade" id="audioModal" tabindex="-1" role="dialog" aria-labelledby="audioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Pemutar Audio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <audio controls id="audioPlayer">
                    <source src="" type="audio/mpeg">
                    Browser Anda tidak mendukung pemutar audio.
                </audio>
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
                { data: 'audio', name: 'audio' },
            ]
        });


        $("#inputHafalan").submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url : $(this).attr('action'),
                type : $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                },
                success: function(response) {
                    if(response.status == false) {
                        var err = response.error;
                        iziToast.error({
                            title: 'Error',
                            message: err,
                            position: 'topRight'
                        });
                   }else {
                       iziToast.success({
                            title: 'Success',
                            message: response.pesan,
                            position: 'topRight'
                        });

                   }
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Terjadi kesalahan',
                        position: 'topRight'
                    });
                },complete: function() {
                    $("#basicModal").modal('hide');
                    table.ajax.reload();
                    $("#inputHafalan").trigger('reset');

                }
            })
        })




    });
    // $(".played").click(function(e) {
    //         console.log(e);
    //         var buttonId    = $(this).data('id');
    //         var buttonName  = $(this).data('src');
    //         console.log('ID: ' + buttonId + ', Nama: ' + buttonName);
    //     });

    $(document).on('click', '.played', function() {
        var id  = $(this).data('id');
        var src = $(this).data('src');
        $('#audioPlayer').attr('src', src);
        $('#audioModal').modal('show');
        // Tambahkan logika atau permintaan AJAX Anda di sini
    })

</script>

@endpush


