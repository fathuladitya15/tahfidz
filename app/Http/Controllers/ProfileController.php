<?php

namespace App\Http\Controllers;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
            $file           = $request->file('files');
            $fileName       = time() . '_' . $file->getClientOriginalName();
            $path           = 'audio/'.$fileName;
            return response()->json(['id' => Auth::user()->id,'pesan' => 'Foro berhasil di unggah'],200);
            // $file->move(public_path('assets/img/profile'), $fileName); // Menyimpan file di direktori 'public/audio'
            // Audio::create(['hafalan_id' => $save->id,'path' => $path]);
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
