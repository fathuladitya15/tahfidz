<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hafalan;
use App\Models\Audio;
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
        $save = Hafalan::create([
            'student_id'        => $request->student_id,
            'teacher_id'        => $request->teacher_id,
            'lembar_hafalan'    => $request->LembarHafalan,
            'ayat'              => $request->Ayat,
            'juz'               => $request->Juz,
        ]);

        if ($request->hasFile('audioFile')) {
            $validator = Validator::make($request->all(), [
                'audioFile'         => 'file|mimes:audio/mpeg,mpga,mp3,wav|max:10000',
            ],[
                'audioFile.mimes'   => 'File audio yang di izinkan mpeg,mpga,mp3,wav',
                'audioFile.max'     =>  'Maksimal ukuran file 1 Mb',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => FALSE,'error' => $validator->errors()->first()]);
            }
            $file           = $request->file('audioFile');
            $fileName       = time() . '_' . $file->getClientOriginalName();
            $path           = 'audio/'.$fileName;
            $file->move(public_path('audio'), $fileName); // Menyimpan file di direktori 'public/audio'
            Audio::create(['hafalan_id' => $save->id,'path' => $path]);
        }

        if($save) {
            return response()->json(['status' => TRUE,'pesan' => 'Hafalan tersimpan' ,],200);
        }
        return response()->json(['status' => TRUE,'error' => 'Gagal menyimpan' ,],200);



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
        ->addColumn('audio',function($row) {
            $cekAudio = Audio::where('hafalan_id',$row->id)->count();
            if($cekAudio == 1) {
                $dataAudio = Audio::where('hafalan_id',$row->id)->first();
                $button = '<button class="btn btn-sm btn-primary played" data-id="'.$row->id.'" data-src="'.asset($dataAudio->path).'"  ><i class="bx bx-play"></i></button>';
            }else {
                $button = "";

            }
            return $button;
        })
        // ->addColumn('aksi',function($row) {

        //     $button = "<a href='".route('user-edit',['id' => $row->id])."'  class='btn btn-primary btn-sm'>Edit</a>";
        //     $button .= '&nbsp;';
        //     $button .= "<a href='".route('user-edit',['id' => $row->id])."'  class='btn btn-danger btn-sm'>Hapus</a>";
        //     return $button;
        // })
        ->rawColumns(['nama_siswa','audio'])
        ->make(true);

        return $dt;

    }
}
