@extends('layouts.master')

@section('title')
    <title>Data Jabatan</title>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Data Jabatan</h1>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#positionModal">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Tambah Data Pegawai
            </button>
        </div>

  <!-- Modal Tambah Data-->
  <div class="modal fade" id="positionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jabatan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form role="form" action="{{route('position.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="">Jabatan</label>
                            <input type="text" name="jabatan" placeholder="Jabatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="">Gaji Pokok</label>
                            <input type="number" min="0" name="gaji_pokok" placeholder="Gaji Pokok" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="">Tunjangan</label>
                            <input type="number" min="0" name="tunjangan" placeholder="Tunjangan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="simpan" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
  </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Jabatan Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jabatan</th>
                            <th>Gaji Pokok</th>
                            <th>Tunjangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($position as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucFirst($p->jabatan) }}</td>
                            <td>Rp. {{ number_format($p->gaji_pokok) }}</td>
                            <td>Rp. {{ number_format($p->tunjangan) }}</td>
                            <td>
                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit{{$p->id}}" data-id="{{ $p->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>

                                <a href="#" class="btn btn-danger delete-data" data-id="{{ $p->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </a>
                            </td>

                            <!-- Modal Edit Data-->
                            <div class="modal fade" id="modalEdit{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Jabatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form role="form" action="{{ route('position.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="">Jabatan</label>
                                                        <input type="text" name="jabatan" value="{{ $p->jabatan }}" placeholder="Jabatan" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Gaji Pokok</label>
                                                        <input type="number" min="0" value="{{ $p->gaji_pokok }}" name="gaji_pokok" placeholder="Gaji Pokok" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Tunjangan</label>
                                                        <input type="number" min="0" value="{{ $p->tunjangan }}" name="tunjangan" placeholder="Tunjangan" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $('.delete-data').click(function(){
            const id_jabatan = $(this).attr('data-id');
            swal({
            title: "Yakin Ingin Menghapus Data?",
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location = "/position/"+id_jabatan+"/delete",
                swal("Data berhasil dihapus!", {
                icon: "success",
                });
            }
            });
        });
    </script>
@endsection