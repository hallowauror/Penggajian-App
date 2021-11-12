@extends('layouts.master')

@section('title')
    <title>Data Kehadiran</title>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Data Kehadiran</h1>
        
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#presenceModal">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Data Kehadiran
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
    <div class="modal fade bd-example-modal-lg" id="presenceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('presence.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="">Nama Pegawai</label>
                                <select name="employee_id" id="employee_id" class="form-control" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    @foreach ($employee as $e)
                                        <option value="{{ $e->id }}">{{ ucFirst($e->nama) }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="">Kehadiran</label>
                                <input type="number" min="0" max="31" name="hadir" placeholder="Jumlah Hadir" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Lebih Jam Mengajar (Jam)</label>
                                <input type="number" min="0" name="lebih_jam" placeholder="Lebih Jam Mengajar" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Insentif Kehadiran</label>
                                <input type="number" min="0" max="31" name="insentif" placeholder="Insentif Kehadiran" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="">Periode</label>
                                <input type="date" name="periode" placeholder="Periode Kehadiran" class="form-control" required>
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
            <h6 class="m-0 font-weight-bold text-primary">Data Kehadiran Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presence as $pre)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pre->employee->nama }}</td>
                            <td>{{ $pre->periode->format('F - Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalShow{{$pre->id}}" data-id="{{ $pre->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </a>

                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit{{$pre->id}}" data-id="{{ $pre->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>

                                <a href="#" class="btn btn-danger delete-data" data-id="{{ $pre->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </a>
                            </td>

                            <!-- Modal Show Data-->
                            <div class="modal fade bd-example-modal-lg" id="modalShow{{$pre->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Kehadiran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form role="form" action="{{ route('presence.show', $pre->id) }}" method="GET" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="">Nama Pegawai</label>
                                                        <select name="employee_id" id="employee_id" disabled class="form-control" required>
                                                            @foreach ($employee as $e)
                                                                @if (old('employee_id', $pre->employee_id) == $e->id)
                                                                    <option value="{{ $e->id }}" selected>{{ ucFirst($e->nama) }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Kehadiran</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->hadir }}" name="hadir" placeholder="Jumlah Hadir" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Lebih Jam Mengajar (Jam)</label>
                                                        <input type="number" min="0" value="{{ $pre->lebih_jam }}" name="lebih_jam" placeholder="Lebih Jam Mengajar" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Insentif Kehadiran</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->insentif }}" name="insentif" placeholder="Insentif Kehadiran" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Periode</label>
                                                        <input type="text" name="periode" value="{{ $pre->periode->format('F - Y') }}" placeholder="Periode Kehadiran" class="form-control" required readonly>
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
                            <div class="modal fade bd-example-modal-lg" id="modalEdit{{$pre->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah Data Kehadiran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form role="form" action="{{ route('presence.update', $pre->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="">Nama Pegawai</label>
                                                        <select name="employee_id" id="employee_id" class="form-control" required>
                                                            @foreach ($employee as $e)
                                                                @if (old('employee_id', $pre->employee_id) == $e->id)
                                                                    <option value="{{ $e->id }}" selected>{{ ucFirst($e->nama) }}</option>
                                                                @else
                                                                <option value="{{ $e->id }}">{{ ucFirst($e->nama) }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Kehadiran</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->hadir }}" name="hadir" placeholder="Jumlah Hadir" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Lebih Jam Mengajar (Jam)</label>
                                                        <input type="number" min="0" value="{{ $pre->lebih_jam }}" name="lebih_jam" placeholder="Lebih Jam Mengajar" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Insentif Kehadiran</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->insentif }}" name="insentif" placeholder="Insentif Kehadiran" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Periode</label>
                                                        <input type="date" name="periode" value="{{ $pre->periode->format('Y-m-d') }}" placeholder="Periode Kehadiran" class="form-control" required>
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
            const id_presence = $(this).attr('data-id');
            swal({
            title: "Yakin Ingin Menghapus Data?",
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location = "/presence/"+id_presence+"/delete",
                swal("Data berhasil dihapus!", {
                icon: "success",
                });
            }
            });
        });
    </script>
@endsection