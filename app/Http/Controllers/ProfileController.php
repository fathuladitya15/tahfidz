<?php

namespace App\Http\Controllers;

use File;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    function __construct() {
        $this->middleware('auth');
    }
    public function index()
    {

        return view('layouts.partials.profile');

    }

    public function update(Request $request, User $user)
    {
        if ($request->hasFile('files')) {
            $validator = Validator::make($request->all(), [
                'files'         => 'file|mimes:jpeg,png,jpg|max:1000',
            ],[
                'files.mimes'   => 'File audio yang di izinkan jpeg,jpg,png',
                'files.max'     =>  'Maksimal ukuran file 1 Mb',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => FALSE,'error' => $validator->errors()->first()]);
            }
            $cekFile        = User::find(Auth::user()->id)->foto;

            if (File::exists($cekFile)) {
                File::delete($cekFile);
            }
            $file           = $request->file('files');
            $fileName       = time() . '_' . $file->getClientOriginalName();
            $path           = 'assets/img/profile/'.$fileName;
            $file->move(public_path('assets/img/profile'), $fileName); // Menyimpan file di direktori 'public/profile'
            $updateUser         = User::find(Auth::user()->id);
            $updateUser->foto   = $path;
            $updateUser->update();
            return response()->json(['id' => Auth::user()->id,'pesan' => 'Foro berhasil di unggah',],200);
        }
        return response()->json(['pesan' => "Error",'status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
