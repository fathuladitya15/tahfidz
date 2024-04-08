<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'username' => 'required|unique:users|max:255',
            'tanggal_lahir' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'alamat'   => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required'

            // tambahkan validasi lain sesuai kebutuhan
        ], [
            'name.required' => 'Nama dibutuhkan.',
            'name.string' => 'Name harus berupa huruf.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email dibutuhkan.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email telah digunakan.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Nama Pengguna telah digunakan.',
            'username.required' => 'Nama Pengguna dibutuhkan',
            'tanggal_lahir.required' => 'Tanggal lahir dibutuhkan',
            'father_name.required' => 'Nama ayah dibutuhkan',
            'mother_name.required' => 'Nama Ibu dibutuhkan',
            'alamat.required'   => 'Alamat dibutuhkan',
            'password.required' => 'Password dibutuhkan',
            'jenis_kelamin.required' => 'Jenis kelamin dibutuhkan'
            // tambahkan pesan kesalahan lain sesuai kebutuhan
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $siswa = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
        ]);
        $siswa->assignRole('student');
        return response()->json(['status' => TRUE,'pesan' => 'Berhasil menambahkan data baru']);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    function data (Request $request) {
        $user = User::find(Auth::user()->id);
        $roles = $user->getRoleNames()->join(', ');

        if($roles == 'admin'){
            $data  = User::all();
        }else {
            $data = User::all();
        }

        $dt = DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi',function($row) {

            $button = "<a href='#'  class='btn btn-primary btn-sm'>Edit Siswa</a>";
            return $button;
        })
        ->rawColumns(['aksi'])
        ->make(true);

        return $dt;
    }
}
