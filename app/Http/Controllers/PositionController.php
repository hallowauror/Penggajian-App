<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        return view('positions.index', [
            'position' => Position::all()->sortBy('jabatan'),
        ]);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'jabatan' =>'required|string|max:50',
            'gaji_pokok'=>'required|min:0',
            'tunjangan' => 'required|min:0',
        ]);

        try {
            $positions = Position::create([
                'jabatan' => $request->jabatan,
                'slug' => Str::slug($request->jabatan),
                'gaji_pokok' => $request->gaji_pokok,
                'tunjangan' => $request->tunjangan,
            ]);

            return redirect('/position')->with(['sukses' => 'Data berhasil ditambahkan!']);
        } catch (\Exception $e) {
            return redirect('/position')->with(['gagal' => 'Data Gagal untuk disimpan']);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'jabatan' =>'required|string|max:50',
            'gaji_pokok'=>'required|min:0',
            'tunjangan' => 'required|min:0',
        ]);

        try {

            $positions = Position::find($id);

            $positions->update([
                'jabatan' => $request->jabatan,
                'slug' => Str::slug($request->jabatan),
                'gaji_pokok' => $request->gaji_pokok,
                'tunjangan' => $request->tunjangan,
            ]);

            return redirect('/position')->with(['sukses' => 'Data berhasil diubah!']);
        } catch (\Exception $e) {
            return redirect('/position')->with(['gagal' => $e->getMessage()]);
        }
    }
    
    public function delete(Position $position)
    {
        $position->delete($position);
        return redirect('/position')->with('success', 'Data berhasil dihapus!');
    }
}
