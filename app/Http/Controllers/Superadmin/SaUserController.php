<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HakAkses;
use App\Models\LevelUser;
use Illuminate\Support\Facades\Validator;

class SaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::where('parent_id', null)->get();
        $level = LevelUser::all();
        $hak = HakAkses::all();
        return view('dashboard.superadmin.sauser.index', compact('menu','level','hak'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($_POST);
        $validasi = Validator::make($request->all(), [
            'nama' => 'required|max:100|string',
        ]);
        if ($validasi->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $validasi->errors()->first() .
                        'Pastikan anda mengisi semua inputan'
                );
        }
        $level = new LevelUser();
        $level->nama = $request->nama;
        $level->save();
        return redirect()
            ->back()
            ->with('success', 'Menu berhasil dai tambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
