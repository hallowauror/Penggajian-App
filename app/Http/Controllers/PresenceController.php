<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employee;

class PresenceController extends Controller
{
    public function index()
    {
        return view('presence.index', [
            'employee' => Employee::with('position')->get(),
            'presence' => Presence::with('employee.position')->orderBy('created_at', 'DESC')->get()
        ]);
    }

    public function show($presence)
    {
        return view ('presence.index', [
            'presence' => Presence::findOrFail($presence)
        ]);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'hadir' => 'required|integer|min:0|max:31',
            'lebih_jam' => 'required|integer',
            'insentif' => 'required|integer|max:31',
            'periode' => 'required',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        try {
            
            $pegawai = Employee::where('id', $request->employee_id)->with('position')->first();
            $gapok = $pegawai->position->gaji_pokok;
            $tunjangan = $pegawai->position->tunjangan;

            if($pegawai->masa_kerja > 2){
                $masa_kerja = 150000;
            } else {
                $masa_kerja = 0;
            }
            
            $kehadiran = $request->hadir * 40000;
            $lebih = $request->lebih_jam * 10000;
            $insen = $request->insentif * 10000;
            

            $total = $kehadiran + $lebih + $insen + $gapok + $tunjangan + $masa_kerja;
            
            $presences = Presence::create([
                'hadir' => $request->hadir,
                'lebih_jam' => $request->lebih_jam,
                'insentif' => $request->insentif,
                'periode' => $request->periode,
                'employee_id' => $request->employee_id,
                'total_gaji' => $total
            ]);

            return redirect('/presence')->with(['sukses' => 'Data berhasil ditambahkan!']);
        } catch (\Exception $e) {
            return redirect('/presence')->with(['gagal' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'hadir' => 'required|integer|min:0|max:31',
            'lebih_jam' => 'required|integer',
            'insentif' => 'required|max:31|integer',
            'periode' => 'required',
            'employee_id' => 'required|exists:employees,id'
        ]);

        try {
            
            $presence = Presence::find($id);

            $pegawai = Employee::where('id', $request->employee_id)->with('position')->first();
            $gapok = $pegawai->position->gaji_pokok;
            $tunjangan = $pegawai->position->tunjangan;

            if($pegawai->masa_kerja > 2){
                $masa_kerja = 150000;
            } else {
                $masa_kerja = 0;
            }
            
            $kehadiran = $request->hadir * 40000;
            $lebih = $request->lebih_jam * 10000;
            $insen = $request->insentif * 10000;
            

            $total = $kehadiran + $lebih + $insen + $gapok + $tunjangan + $masa_kerja;

            $presence->update([
                'hadir' => $request->hadir,
                'lebih_jam' => $request->lebih_jam,
                'insentif' => $request->insentif,
                'periode' => $request->periode,
                'employee_id' => $request->employee_id,
                'total_gaji' => $total
            ]);

            return redirect('/presence')->with(['sukses' => 'Data berhasil diubah!']);
        } catch (\Exception $e) {
            return redirect('/presence')->with(['gagal' => $e->getMessage()]);
        }
    }

    public function delete(Presence $presence)
    {
        Presence::destroy($presence->id);
        return redirect('/presence')->with('success', 'Data berhasil dihapus!');
    }

    public function payroll()
    {
        return view('payroll.index', [
            'employee' => Employee::with('position')->get(),
            'presence' => Presence::with('employee.position')->orderBy('created_at', 'DESC')->get()
        ]);
    }
}
