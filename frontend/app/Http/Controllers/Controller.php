<?php

namespace App\Http\Controllers;
use App\Utils\HttpResponse;
use App\Utils\HttpResponseCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

abstract class Controller
{
    use HttpResponse;

    public function getApi($url, $token=null)
    {
        if($token) {
            $response = Http::withToken($token)->get($url);
        } else {
            $response = Http::get($url);
        }

        return $response;
    }

    public function postApi($url, array $data, $token = null)
    {
        // 1. Tentukan client
        $client = $token ? Http::withToken($token) : Http::acceptJson();

        // 2. Pisahkan data biasa dan file
        $files = [];
        $dataWithoutFiles = [];
        foreach ($data as $key => $value) {
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $files[$key] = $value;
            } else {
                $dataWithoutFiles[$key] = $value;
            }
        }

        // 3. Jika tidak ada file, kirim seperti biasa
        if (empty($files)) {
            return $client->post($url, $dataWithoutFiles);
        }

        // 4. Jika ADA FILE, gunakan ->attach() untuk setiap file
        foreach ($files as $key => $file) {
            $client->attach(
                $key,                            // Nama field, misal: 'profile_picture'
                file_get_contents($file->getRealPath()), // Konten file
                $file->getClientOriginalName()   // Nama file asli
            );
        }

        // 5. Kirim request dengan data biasa dan file yang sudah terlampir
        return $client->post($url, $dataWithoutFiles);
    }

    public function deleteApi($url, $token = null)
    {
        $client = $token ? Http::withToken($token) : Http::acceptJson();
        return $client->delete($url);
    }

    public function putApi($url, array $data, $token = null)
    {
        $client = $token ? Http::withToken($token) : Http::acceptJson();
        return $client->put($url, $data);
    }
}
