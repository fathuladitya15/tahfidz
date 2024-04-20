@extends('layouts.Master')
@section('title'){{ 'Tambah Data siswa' }}@endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Pengguna /</span> Tambah data pengguna</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Tambah data pengguna</h5>

            <form id="formDataSiswa">
                @csrf
                <div class="card-body">
                    <a style="float: right;" href="{{ route('user-index') }}" class="btn btn-primary"> Kembali</a>
                    <br><br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="namaSiswa" class="form-label">Nama Pengguna</label>
                            <input type="text" id="namaSiswa" class="form-control" name="name" required placeholder="Masukan nama pegguna" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" id="tanggalLahir" class="form-control" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="namaAyah" class="form-label">Nama Ayah</label>
                            <input type="text" id="namaAyah" class="form-control" name="father_name" required placeholder="Masukan nama ayah" value="{{ old('father_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="nama_ibu" class="form-label">Nama ibu</label>
                            <input type="text"  id="nama_ibu" class="form-control" name="mother_name" placeholder="Masukan nama ibu" required value="{{ old('mother_name') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" required class="form-control">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki Laki</option>
                                <option value="P" {{ old('father_name')  == 'P' ? 'selected' : ''}}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text"  id="alamat" class="form-control" name="alamat" placeholder="Masukan alamat detail" required value="{{ old('alamat') }}">
                        </div>
                    </div>
                    @php
                        $roles = Auth::user()->getRoleNames()->join(', ');
                    @endphp
                    @if($roles == 'admin')
                        <div class="row">
                            <div class="col-md-6">
                                <label for="JenisAkun">Sebagai ? </label>
                                <select name="sebagai" id="sebagai" class="form-control" required>
                                    <option value="admin">Admin</option>
                                    <option value="student">Murid</option>
                                    <option value="teacher">Guru</option>
                                </select>

                            </div>
                        </div>
                    @endif

                    <hr>
                    Informasi Akun
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control" name="username" required placeholder="Masukan username" value="{{ old('username') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" name="email" required placeholder="exmaple@ex.com" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" required placeholder="xxx">
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="confirm_password" id="confirm_password" class="form-control" name="confirm_password" required placeholder="xxxx">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#formDataSiswa').submit(function(e) {
        e.preventDefault();
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        if (passwordInput.value !== confirmPasswordInput.value) {
            // Jika tidak sama, hentikan proses submit
            event.preventDefault();
            // Tampilkan pesan kesalahan
            iziToast.error({
                title: 'Error',
                message: 'Password tidak sesuai ',
                position: 'topRight'
            });
            // Bersihkan nilai input konfirmasi password
            confirmPasswordInput.value = '';
            // Fokuskan kembali ke input konfirmasi password
            confirmPasswordInput.focus();
        }else {
            $.ajax({
                url : "{{ route('user-store') }}",
                type: "POST",
                data: $(this).serialize(),
                beforeSend: function() {
                    iziToast.info({
                        title: 'Loading',
                        message: 'Please wait...',
                        position: 'topRight'
                    });
                }, success : function(s) {
                    if(s.status == true) {
                        iziToast.success({
                            title: 'Sukses',
                            message: s.pesan,
                            position: 'topRight',
                        });

                    }else {
                        iziToast.error({
                            title: 'Terjadi Kesalahan',
                            message: 'Hubungi Tim IT',
                            position: 'topRight'
                        });
                        console.log(s);
                    }
                }, error : function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    iziToast.error({
                        title: 'Error',
                        message: errorHtml,
                        position: 'topRight'
                    });
                    iziToast.hide({}, document.querySelector('.iziToast'));
                }, complete: function() {
                    // $("#formDataSiswa").trigger('reset');

                }
            })
        }
    })
</script>

@endpush
