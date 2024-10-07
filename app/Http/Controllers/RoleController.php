<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('users.roles', compact('roles'));
    }


    public function store( Request $request ) 
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Peran berhasil ditambahkan.');
        
    }

    public function update( Request $request, $id ){
        $validate = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        return back()->with('success', 'Peran berhasil diubah.');
    }

    public function destroy( $id ) 
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return back()->with('success', 'Peran berhasil dihapus.');
    }


}
