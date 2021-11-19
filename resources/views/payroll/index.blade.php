@extends('layouts.master')

@section('title')
    <title>Data Kehadiran</title>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penggajian</h1>
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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penggajian Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presence as $pre)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucFirst($pre->employee->nama) }}</td>
                            <td>{{ ucFirst($pre->employee->position->jabatan) }}</td>
                            <td>{{ $pre->periode->format('F - Y') }}</td>
                            <td>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#modalShow{{$pre->id}}" data-id="{{ $pre->id }}">
                                    <span class="icon text-white-100">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </a>
                            </td>

                            <!-- Modal Show Data-->
                            <div class="modal fade bd-example-modal-lg" id="modalShow{{$pre->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail Data Penggajian</h5>
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
                                                    <label class="">Transport & Makan (Rp. 40.000)</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->hadir  * 40000 }}" name="hadir" placeholder="Jumlah Hadir" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Lebih Jam Mengajar (Rp. 10.000)</label>
                                                        <input type="number" min="0" value="{{ $pre->lebih_jam * 10000 }}" name="lebih_jam" placeholder="Lebih Jam Mengajar" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Insentif Kehadiran (Rp. 10.000)</label>
                                                        <input type="number" min="0" max="31" value="{{ $pre->insentif * 10000 }}" name="insentif" placeholder="Insentif Kehadiran" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Masa Kerja > 2 Tahun (Rp. 150.000)</label>
                                                        <select name="employee_id" id="employee_id" disabled class="form-control" required>
                                                            @foreach ($employee as $e)
                                                                @if (old('employee_id', $pre->employee_id) == $e->id)
                                                                    <option value="{{ $e->id }}" selected>
                                                                        @if ($e->masa_kerja > 2)
                                                                            150000
                                                                        @else
                                                                            0
                                                                        @endif
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Periode</label>
                                                        <input type="text" name="periode" value="{{ $pre->periode->format('F - Y') }}" placeholder="Periode Kehadiran" class="form-control" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <label class="">Total Gaji</label>
                                                        <input type="text" name="total_gjai" value="{{ number_format($pre->total_gaji) }}" placeholder="Total Gaji" class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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