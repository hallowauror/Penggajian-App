@extends('layouts.master')

@section('title')
    <title>Data Pegawai</title>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Data Pegawai</h1>
        
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#employeeModal">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Data Pegawai
        </button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="">NIK</label>
                                <input type="number" name="nik" placeholder="NIK" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Nama Lengkap</label>
                                <input type="nama" name="nama" placeholder="Nama Lengkap" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Alamat</label>
                                <textarea name="alamat" placeholder="Alamat" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="">Nomor Telpon</label>
                                <input type="number" min="0" name="no_telp" placeholder="Telpon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Masa Kerja (Tahun)</label>
                                <input type="number" min="0" name="masa_kerja" placeholder="Masa Kerja" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Jabatan</label>
                                <select name="position_id" id="position_id" class="form-control" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($positions as $p)
                                        <option value="{{ $p->id }}">{{ ucFirst($p->jabatan) }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="">Foto Pegawai</label>
                                <input type="file" name="foto" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup </button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee as $e)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if (!empty($e->foto))
                                    <img src="{{ asset('storage/' . $e->foto) }}" width="100px" height="100px"  alt="">
                                @else
                                    <img src="http://via.placeholder.com/100x100" alt="{{ $e->name }}">
                                @endif
                            </td>
                            <td>{{ $e->nik }}</td>
                            <td>{{ ucFirst($e->nama) }}</td>
                            <td>{{ ucFirst($e->position->jabatan) }}</td>
                            <td>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalShow{{$e->id}}" data-id="{{ $e->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </a>

                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit{{$e->id}}" data-id="{{ $e->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>

                                <a href="#" class="btn btn-danger delete-data" data-id="{{ $e->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </a>
                            </td>

                            <!-- Modal Show Data-->
                            <div class="modal fade bd-example-modal-lg" id="modalShow{{$e->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Pegawai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form role="form" action="{{ route('employee.show', $e->id) }}" method="GET" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="">NIK</label>
                                                        <input type="number" name="nik" value="{{ $e->nik }}" placeholder="NIK" class="form-control" readonly required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Nama Lengkap</label>
                                                        <input type="nama" name="nama" value="{{ $e->nama }}" placeholder="Nama Lengkap" class="form-control" readonly required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Alamat</label>
                                                        <textarea name="alamat" placeholder="Alamat" class="form-control" rows="3" required readonly>{{ $e->alamat }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Nomor Telpon</label>
                                                        <input type="number" min="0" value="{{ $e->no_telp }}" name="no_telp" placeholder="Telpon" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Masa Kerja (Tahun)</label>
                                                        <input type="number" min="0" value="{{ $e->masa_kerja }}" name="masa_kerja" placeholder="Masa Kerja" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Jabatan</label>
                                                        <select name="position_id" id="position_id" disabled class="form-control" required>
                                                            <option disabled>-- Pilih Jabatan --</option>
                                                            @foreach ($positions as $p)
                                                                @if (old('position_id', $e->position_id) == $p->id)
                                                                    <option value="{{ $p->id }}" selected>{{ ucFirst($p->jabatan) }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Data-->
                            <div class="modal fade bd-example-modal-lg" id="modalEdit{{$e->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Data Pegawai</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form role="form" action="{{ route('employee.update', $e->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="">NIK</label>
                                                        <input type="number" name="nik" value="{{ $e->nik }}" placeholder="NIK" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Nama Lengkap</label>
                                                        <input type="nama" name="nama" value="{{ $e->nama }}" placeholder="Nama Lengkap" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Alamat</label>
                                                        <textarea name="alamat" placeholder="Alamat" class="form-control" rows="3" required>{{ $e->alamat }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Nomor Telpon</label>
                                                        <input type="number" min="0" value="{{ $e->no_telp }}" name="no_telp" placeholder="Telpon" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Masa Kerja (Tahun)</label>
                                                        <input type="number" min="0" value="{{ $e->masa_kerja }}" name="masa_kerja" placeholder="Masa Kerja" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Jabatan</label>
                                                        <select name="position_id" id="position_id" class="form-control" required>
                                                            <option value="">-- Pilih Jabatan --</option>
                                                            @foreach ($positions as $p)
                                                                @if (old('position_id', $e->position_id) == $p->id)
                                                                    <option value="{{ $p->id }}" selected>{{ ucFirst($p->jabatan) }}</option>
                                                                @else
                                                                    <option value="{{ $p->id }}">{{ ucFirst($p->jabatan) }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Foto Pegawai</label>
                                                        <p class="text-danger">Abaikan jika tidak ingin mengganti foto.</p>
                                                        <input type="hidden" name="oldFoto" value="{{ $e->foto }}">
                                                        <input type="file" name="foto" class="form-control-file">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Ubah</button>
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
            const id_employee = $(this).attr('data-id');
            swal({
            title: "Yakin Ingin Menghapus Data?",
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location = "/employee/"+id_employee+"/delete",
                swal("Data berhasil dihapus!", {
                icon: "success",
                });
            }
            });
        });
    </script>
@endsection