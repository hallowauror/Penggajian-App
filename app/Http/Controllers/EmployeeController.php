<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index', [
            'employee' => Employee::with('position')->orderBy('nama')->get(),
            'positions' => Position::all()
        ]);
    }

    public function show($employee)
    {
        return view('employee.index', [
            'employee' => Employee::findOrFail($employee)
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nik' => 'required|digits:16|unique:employees',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'masa_kerja' => 'required|integer',
            'position_id' => 'required|exists:positions,id',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:1024'
        ]);

        try {
            $foto = null;

            if($request->file('foto')){
                $foto = $request->file('foto')->store('foto_pegawai');
            }

            $employees = Employee::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'masa_kerja' => $request->masa_kerja,
                'position_id' => $request->position_id,
                'foto' => $foto
            ]);

            return redirect('/employee')->with(['sukses' => 'Data berhasil ditambahkan!']);
        } catch (\Exception $e) {
            return redirect('/employee')->with(['gagal' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nik' => 'required|digits:16|exists:employees,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'masa_kerja' => 'required|integer',
            'position_id' => 'required|exists:positions,id',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:1024'
        ]);

        try {
            
            $employee = Employee::find($id);

            $foto = $employee->foto;

            if($request->file('foto')){
                if($request->oldFoto){
                    Storage::delete($request->oldFoto);
                }
                $foto = $request->file('foto')->store('foto_pegawai');
            }

            $employee->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'masa_kerja' => $request->masa_kerja,
                'position_id' => $request->position_id,
                'foto' => $foto
            ]);

            return redirect('/employee')->with(['sukses' => 'Data berhasil diubah!']);
        } catch (\Exception $e) {
            return redirect('/employee')->with(['gagal' => $e->getMessage()]);
        }

    }

    public function delete(Employee $employee)
    {
        if($employee->foto){
            Storage::delete($employee->foto);
        }

        Employee::destroy($employee->id);
        return redirect('/employee')->with('success', 'Data berhasil dihapus!');
    }
}
