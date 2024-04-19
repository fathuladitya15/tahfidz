<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hafalan;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class HafalanController extends Controller
{

    function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::role('student')->get();
        return view('layouts.hafalan.index',compact('students'));
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
        $validator = Validator::make($request->all(), [
            'audioFile' => 'file|mimes:audio/mpeg,mpga,mp3,wav|max:10000',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function data (Request $request) {
        $data = Hafalan::where('teacher_id',Auth::user()->id)->with(['student','teacher'])->get();
        $dt = DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('nama_siswa',function($row) {
            return $row->student->name;
        })
        // ->addColumn('aksi',function($row) {

        //     $button = "<a href='".route('user-edit',['id' => $row->id])."'  class='btn btn-primary btn-sm'>Edit</a>";
        //     $button .= '&nbsp;';
        //     $button .= "<a href='".route('user-edit',['id' => $row->id])."'  class='btn btn-danger btn-sm'>Hapus</a>";
        //     return $button;
        // })
        ->rawColumns(['nama_siswa'])
        ->make(true);

        return $dt;

    }
}
