<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

class RoleController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
    */
    public function index()
    {
        $search = Request()->term;
        $roles = Role::search($search);
        return view('admin.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
    */
    public function new()
    {
        $role = new Role();
        return view('admin.roles.new', ['role' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return  \Illuminate\View\View | \Illuminate\Http\RedirectResponse.
    */
    public function create(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:roles,name'
        ]);

        $role = new Role($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.roles.new', ['role' => $role])->withErrors($validator);
        }

        $role->save();
        return redirect()->route('admin.roles')->with('success', 'Cargo cadastrado com sucesso');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role $id
     * @return  \Illuminate\View\View
    */
    public function edit($id)
    {
        $role = Role::find($id);
        return view('admin.roles.edit', ['role' => $role]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Role $id
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
    */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $data = array_filter($request->all());

        $validator = Validator::make($data, [
            'name' => "required|unique:roles,name,{$role->id}"
        ]);

        $role->fill($data);
        if ($validator->fails()) {
            $request->session()->flash('danger', 'Existem dados incorretos! Por favor verifique!');
            return view('admin.roles.edit', ['role' => $role])->withErrors($validator);
        }

        $role->save();
        return redirect()->route('admin.roles')->with('success', 'Cargo atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role $id
     * @return \Illuminate\Http\RedirectResponse
     *
    */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('admin.roles')->with('success', 'Cargo removido com sucesso.');
    }
}
