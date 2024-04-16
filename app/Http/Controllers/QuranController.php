<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_juz($juz)
    {
        $url = 'http://api.alquran.cloud/v1/juz/'.$juz.'/en.asad';
        $dataArray = $this->curl($url);
        $surat = [];

        foreach ($dataArray['data']['surahs'] as $ke) {
            $surat[] = [
                'Nama Surat' => $ke['englishName'],
            ];
        }

        array_push($surat,['juz' => 'Juz ke-'. $juz]);


        dd($surat);


        $dataAyat = [];
        foreach ($ayat as $ay) {
            $dataAyat = $ay;
        }

        return response()->json($dataArray["data"]["ayahs"]);
    }

    public function get_ayat($ayat) {
        $url = 'http://api.alquran.cloud/v1/ayah/';
        $ch = curl_init();

        // Set URL dan opsi lainnya
        curl_setopt($ch, CURLOPT_URL, $urls);
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

        return response()->json($dataArray);
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
    public function show(string $id)
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
}
