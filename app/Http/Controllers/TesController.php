<?php

namespace App\Http\Controllers;

use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        $tes = Tes::all();
        return view('tes.index', compact('tes'));
    }

    public function create()
    {
        return view('tes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'name' => 'required',
        ), array(
            'name.required' => 'name field is required',
        ));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $Tes = new tes;



        // simpan data ke database

        Tes::create($request->all());

        return redirect()->route('tes.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $Tes = Tes::findOrFail($id);

        return view('Tes.show', compact('tes'));
    }

    public function edit($id)
    {
        $Tes = Tes::findOrFail($id);

        return view('Tes.edit', compact('TesController'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Tes, TesController);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tes = Tes::findOrFail($id);
        $tes->update($request->all());

        return redirect()->route('Tes.index')->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $tes = Tes::findOrFail($id);
        $tes->delete();

        return redirect()->route('Tes.index')->with('success', 'Data berhasil dihapus.');
    }
}
