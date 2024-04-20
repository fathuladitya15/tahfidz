<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hafalan;
use App\Models\Audio;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;


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
        $roles = Auth::user()->getRoleNames()->join(', ');
        if($roles == 'student') {
            $totalAyat      = Hafalan::where('student_id',Auth::id())
                                ->selectRaw('student_id, SUM(ayat_end - ayat_start + 1) as total_ayat')
                                ->groupBy('student_id')
                                ->orderBy('student_id')
                                ->first()->total_ayat;
            $percentAyat    = round(((int)$totalAyat / 6666) * 100,2);
            $totalJuz       = Hafalan::select('juz')->distinct()->where('student_id',Auth::id())->count('juz');
            $percentJuz     = round(($totalJuz / 30)* 100 );
            // dd($percentJuz);

            return view('layouts.hafalan.indexStudent',compact('totalAyat','percentAyat','percentJuz','totalJuz'));
        }
        else if($roles == 'teacher') {
            $students   = User::role('student')->get();
            $getSurat   = $this->fetchDataFromApi();
            dd($getSurat);
            return view('layouts.hafalan.index',compact('students'));
        }
        else if($roles == 'admin') {

        }
        else {
            return abort(401);
        }

    }
    public function store(Request $request)
    {
        $save = Hafalan::create([
            'student_id'        => $request->student_id,
            'teacher_id'        => $request->teacher_id,
            'lembar_hafalan'    => $request->LembarHafalan,
            'ayat_start'        => $request->AyatStart,
            'ayat_end'          => $request->AyatEnd,
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

    public function show($id) {
        $Get            = Hafalan::find($id);
        $urlHalaman     = 'http://api.alquran.cloud/v1/page/1/quran-uthmani';
        $urlJuz         = 'http://api.alquran.cloud/v1/juz/1/quran-uthmani';
        $urlSurah       = 'http://api.alquran.cloud/v1/surah/1';

        $halaman        = $this->curl($urlHalaman);
        $juz            = $this->curl($urlJuz);
        $DetailSurah    = $this->curl($urlSurah);

        $arrJuz         = [];
        foreach ($juz['data']['surahs'] as $key => $value) {
            $arrJuz[]   =   [
                'namaSurat' =>  $value['englishName'],
                'detail'    =>  $this->get_ayat_by_surah('http://api.alquran.cloud/v1/surah/'.$value['number']),
            ];
        }
        dd($arrJuz,$juz['data'],$DetailSurah['data']['ayahs']);
    }

    function data (Request $request) {
        $data = Hafalan::orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal dibuat, data terbaru pertama
        ->get()
        ->groupBy('student_id') // Kelompokkan berdasarkan student_id
        ->map(function ($group) {
            return $group->first(); // Ambil data pertama dari setiap kelompok
        })
        ->values();
        $dt     = DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('ayat',function ($row) {
            $r = $row->ayat_start.'-'.$row->ayat_end;
            return $r;
        })
        ->addColumn('nama_siswa',function($row) {
            $nama = User::find($row->student_id);

            return $nama->name;
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
        ->addColumn('aksi',function($row) {
            $b  = '<a href="'.route('hafalan-show',['id' => $row->id]).'">Detail</a>';
            return $b;
        })
        ->rawColumns(['nama_siswa','audio','aksi','ayat'])
        ->make(true);

        return $dt;

    }

    function get_ayat_by_surah($url) {
        $ch = curl_init();

        // Set URL dan opsi lainnya
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Hanya gunakan jika API tidak menggunakan SSL valid

        // Eksekusi cURL dan dapatkan respons
        $response = curl_exec($ch);

        // Cek jika ada error
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }

        // Tutup session cURL
        curl_close($ch);


        // Konversi respons JSON menjadi array
        $dataArray = json_decode($response, true);

        return $dataArray['data']['ayahs'];
    }

    function curl($url) {
        $ch = curl_init();

        // Set URL dan opsi lainnya
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Hanya gunakan jika API tidak menggunakan SSL valid

        // Eksekusi cURL dan dapatkan respons
        $response = curl_exec($ch);

        // Cek jika ada error
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        }

        // Tutup session cURL
        curl_close($ch);


        // Konversi respons JSON menjadi array
        $dataArray = json_decode($response, true);
        return $dataArray;
    }

    public function fetchDataFromApi()
{
    $client = new Client();

    try {
        $response = $client->request('GET', 'http://api.alquran.cloud/v1/quran/quran-uthmani');

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $data = json_decode($response->getBody(), true);

            // Lakukan sesuatu dengan data yang diterima
            return $data;
        } else {
            return "Gagal mengambil data. Status code: " . $statusCode;
        }
    } catch (\GuzzleHttp\Exception\ClientException $e) {
        return "Error: " . $e->getMessage();
    }
}
}
