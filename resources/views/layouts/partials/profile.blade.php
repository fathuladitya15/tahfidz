@extends('layouts.Master')
@section('title') {{ 'Profile' }} @endsection
@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Profile</h4>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item">
        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Detail Data</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class='bx bxs-lock me-1' ></i> Akun</a
        >
      </li>
    </ul>
    <div class="card mb-4">
      <h5 class="card-header">Detail Profile</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ Auth::user()->foto == null ? asset("assets/img/avatars/1.png") : Auth::user()->foto }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Unggah foto profile</span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" name="foto"/>
            </label>
            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
          </div>
        </div>
      </div>
      <hr class="my-0" />
      <div class="card-body">
        <form id="formAccountSettings" method="POST" onsubmit="return false">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label">Nama Lengkap</label>
              <input class="form-control" type="text" id="firstName" name="firstName"  autofocus value="{{ Auth::user()->name }}" readonly/>
            </div>
            <div class="mb-3 col-md-6">
              <label for="lastName" class="form-label">Tangal Lahir</label>
              <input class="form-control" type="text" name="lastName" id="lastName"  value="{{ \Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->translatedFormat('l, d F Y') }}" readonly />
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Nama Ayah</label>
              <input class="form-control" type="text" id="email" name="email" value="{{ Auth::user()->father_name }}" readonly  />
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Nama Ibu</label>
              <input type="text" class="form-control" id="organization" name="organization" value="{{ Auth::user()->mother_name }}" readonly />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="phoneNumber">Jenis Kelamin</label>
              <input type="text" class="form-control" id="" name="" value="{{ Auth::user()->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}" readonly />

            </div>
            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Alamat</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ Auth::user()->alamat }}" readonly />
            </div>
          </div>
        </form>
      </div>
      <!-- /Account -->
    </div>
  </div>
</div>
@endsection
