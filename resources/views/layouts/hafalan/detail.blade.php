@extends('layouts.Master')
@section('title'){{ 'Data Hafalan' }}@endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"> <span class="text-muted fw-light">Data Hafalan /</span> {{ $dataUser->name }} </h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Histori Hafalan</h5>
            <div class="card-body">
                <div class="row">
                </div>
                <br><br>
                <div class="row">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="table">
                          <thead>
                            <tr class="text-nowrap">
                              <th>#</th>
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

<!-- Modal Add Audio -->
<div class="modal fade" id="AddaudioModal" tabindex="-1" role="dialog" aria-labelledby="AddaudioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Upload Audio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('upload-audio') }}" method="POST" enctype="multipart/form-data" id="UploadAudio">
                @csrf
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="InputSuara" class="form-label">Suara</label>
                            <input type="file" id="audioFile" name="audioFile" class="form-control" required  />
                            <input type="hidden" name="hafalan_id" id="hafalan_id" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan Audio</button>
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
            ajax: "{{ route('hafalan-data-id',['id' => $id]) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                { data: 'lembar_hafalan', name: 'lembar_hafalan' },
                { data: 'ayat', name: 'ayat' },
                { data: 'juz', name: 'juz' },
                { data: 'audio', name: 'audio' },
            ]
        });


        $("#UploadAudio").submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $.ajax({
                url     : $(this).attr('action'),
                type    : $(this).attr('method'),
                data    : formData,
                processData: false,
                contentType: false,
                beforeSend: function() {

                },success: function(response) {
                    // console.log(response);
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
                },error : function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Terjadi kesalahan',
                        position: 'topRight'
                    });
                },complete: function() {
                        $("#AddaudioModal").modal('hide');
                        table.ajax.reload();
                        $("#UploadAudio").trigger('reset');

                    }
            })
        });

        $(document).on('click','.delData', function() {
            var id = $(this).data('id');
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hapus Hafalan ?',
                message: 'Anda akan menghapus data hafalan dan audio ',
                position: 'center',
                buttons: [
                    ['<button><b>Ya</b></button>', function (instance, toast) {
                        $.ajax({
                            url     : "{{ route('halafan-delete') }}",
                            type    : 'DELETE',
                            data    : {hafalan_id : id},
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                            },success: function(response) {
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
                            }, error: function(xhr, status, error) {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Terjadi kesalahan',
                                    position: 'topRight'
                                });
                            },complete: function() {
                                table.ajax.reload();

                            }
                        })
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>Tidak</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        })

        $(document).on('click','.delAudio', function() {
            var id  = $(this).data('id');
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hapus Audio ?',
                message: 'Anda akan menghapus data audio saja',
                position: 'center',
                buttons: [
                    ['<button><b>Ya</b></button>', function (instance, toast) {
                        $.ajax({
                            url     : "{{ route('halafan-delete-audio') }}",
                            type    : 'DELETE',
                            data    : {hafalan_id : id},
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));

                            },success: function(response) {
                                console.log(response);
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
                            }, error: function(xhr, status, error) {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Terjadi kesalahan',
                                    position: 'topRight'
                                });
                            },complete: function() {
                                table.ajax.reload();

                            }
                        })
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }, true],
                    ['<button>Tidak</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        })

    });

    $(document).on('click', '.played', function() {
        var id  = $(this).data('id');
        var src = $(this).data('src');
        $('#audioPlayer').attr('src', src);
        $('#audioModal').modal('show');
    })

    $(document).on('click','.addAudio', function () {
        var id      = $(this).data('id');
        document.getElementById('hafalan_id').value = id;
        $('#AddaudioModal').modal('show');
    });

</script>

@endpush


