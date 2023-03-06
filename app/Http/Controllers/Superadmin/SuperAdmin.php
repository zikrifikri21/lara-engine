<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\LevelUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuperAdmin extends Controller
{
    public function index()
    {
        $menu = Menu::where('parent_id', null)->get();
        return view('dashboard.superadmin.index', compact('menu'));
    }

    public function store(Request $request)
    {
        // dd($_POST);
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:40',
            'slug' => 'required|unique:menus,slug',
            'icon' => 'required|string|max:40',
            'link' => 'required|string|max:40',
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
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->slug = $request->slug;
        $menu->icon = $request->icon;
        $menu->link = $request->link;
        $menu->parent_id = $request->parent_id;
        $menu->user_id = Auth::user()->id;
        $menu->save();
        return redirect()
            ->back()
            ->with('success', 'Menu berhasil dai tambah');
    }
    public function edit(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu = Menu::where('parent_id', null)->get();
        return view('dashboard.superadmin.modal', compact('menu'));
    }
    public function update(Request $request, $id)
    {
        // dd($_POST);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:menus,slug,'.$id,
            'icon' => 'required|max:255',
            'link' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $validator->errors()->first() .
                        'Pastikan anda mengisi semua inputan'
                );
        }
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->slug = $request->slug;
        $menu->icon = $request->icon;
        $menu->link = $request->link;
        $menu->parent_id = $request->parent_id;
        $menu->save();
        return redirect()
            ->back()
            ->with('success', 'Menu berhasil dai tambah');
    }
    public function destroy($id)
    {
        $x = Menu::findOrFail($id);
        $x->delete();
        return redirect()
            ->back()
            ->with('success', 'Berhasil dihapus!');
    }
}
