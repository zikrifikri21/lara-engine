<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Menu;
use App\Models\HakAkses;
use App\Models\LevelUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HakAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lvl = LevelUser::all();
        $menu = Menu::where('parent_id', null)->get();
        $hak = HakAkses::all();

        return view('dashboard.superadmin.akses.index', compact('lvl', 'menu', 'hak'));
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
        $level_user_id = $request->input('level_user_id');
        $menu_ids = $request->input('menu_id');

        HakAkses::where('level_user_id', $level_user_id)->delete();
        foreach ($menu_ids as $menu_id) {
            HakAkses::create([
                'level_user_id' => $level_user_id,
                'menu_id' => $menu_id
            ]);
        }
        return redirect()->back()->with('success', '');
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
