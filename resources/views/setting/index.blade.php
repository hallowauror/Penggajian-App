@extends('layouts.master')

@section('title')
    <title>Ubah Data Admin</title>
@endsection

@section('content')
    <div class="container-fluid">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ubah Data Admin</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('setting.updateProfile')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                    <input type="text" name="email" readonly class="form-control-plaintext" id="staticEmail" value={{ $user->email }}>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Konfirmasi Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" name="konfirmasi_password" class="form-control" id="inputPassword">
                  </div>
                </div>
                <button class="btn btn-primary" type="submit">Perbarui</button>
              </form>
        </div>
    </div>
        
    </div>
@endsection