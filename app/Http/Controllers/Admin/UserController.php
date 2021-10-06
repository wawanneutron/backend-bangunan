<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->when(request()->q, function ($users) {
            $users->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user) {
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Disimpan !']);
        } else {
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Disimpan !']);
        }
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
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        // cek passwprd
        if ($request->password == null) {
            // update tanpa password
            $user->update([
                'name'  => $request->name,
                'email' => $request->email
            ]);
        } else {
            // update dengan password
            $user = User::findOrFail($id);
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }

        if ($user) {
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Dirubah !']);
        } else {
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Dirubah !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
