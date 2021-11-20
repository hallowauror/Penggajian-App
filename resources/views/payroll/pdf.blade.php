<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Gaji</title>
    <style>
        body{
            padding: 0;
            margin: 0;
        }
        .header{
            text-align: center;
        }
        .page{
            max-width: 80em;
            margin: 0 auto;
        }
        table th,
        table td{
            text-align: left;
        }
        table.layout{
            width: 100%;
            border-collapse: collapse;
        }
        table.display{
            margin: 1em 0;
        }
        table.display th,
        table.display td{
            border: 1px solid #B3BFAA;
            padding: .5em 1em;
        }
​
        table.display th{ background: #D5E0CC; }
        table.display td{ background: #fff; }
​
        table.responsive-table{
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }
​
        .listcust {
            margin: 0;
            padding: 0;
            list-style: none;
            display:table;
            border-spacing: 10px;
            border-collapse: separate;
            list-style-type: none;
        }
​
        .data {
            padding-left: 600px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>SDIT NUUR 'ALAA NUUR</h3>
        <h4>Jln. Buwek Jaya No. 02 Rt 02 Rw 02, Sumber Jaya, Tambun Selatan, Bekasi</h4>
        <hr/>
    </div>
    <div class="data">
        <table>
            <tr>
                <th>Nama</th>
                <td>:</td>
                <td>{{ $presence->employee->nama }}</td>
            </tr>
            <tr>
                <th>Status Kepegawaian </th>
                <td>:</td>
                <td>Tidak Tetap</td>
            </tr>
            <tr>
                <th>Periode Bulan</th>
                <td>:</td>
                <td>{{ $presence->periode->isoFormat('MMMM  Y') }}</td>
            </tr>
        </table>
    </div>
    <div class="page">
        <table class="layout display responsive-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Penerimaan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Mukafaah Pokok</td>
                    <td>Rp {{ number_format($presence->employee->position->gaji_pokok) }}</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>T. Walas</td>
                    <td>Rp {{ number_format($presence->employee->position->tunjangan) }}</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Kehadiran ({{$presence->hadir}})</td>
                    <td>Rp {{ number_format($presence->uang_kehadiran) }}</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Insentif Kehadiran ({{$presence->insentif}})</td>
                    <td>Rp {{ number_format($presence->uang_insentif) }}</td>
                </tr>
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>Kelebihan Jam ({{$presence->lebih_jam}})</td>
                    <td>Rp {{ number_format($presence->uang_lebih_jam) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total Penerimaan</th>
                    <td>Rp {{ number_format($presence->total_gaji) }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="footer">
            <h4 style="text-align: right">Bekasi, {{$presence->periode->isoFormat('D MMMM Y')}}</h4>
            <h4 style="text-align: right">Diterima Oleh</h4>
            <br/>
            <br/>
            <h4 style="text-align: right">{{$presence->employee->nama}}</h4>
        </div>
    </div>
</body>
</html>