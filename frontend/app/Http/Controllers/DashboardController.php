<?php

namespace App\Http\Controllers;

use App\Models\Illustration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Utils\HttpResponse;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
use HttpResponse;

    public function index()
    {
        $arts = []; 

        try {
            $url = env('API_URL') . '/illustrations/dashboard';

            $response = $this->getApi($url);

            if ($response->successful()) {
                $artsData = $response->json('data');
                $arts = json_decode(json_encode($artsData));
                // dd($arts);
            }
            
        } catch (\Exception $e) {
            Log::error('Failed to connect to API for dashboard: ' . $e->getMessage());
            
        }

        return view('dashboard', compact('arts'));
    }

   public function showListings()
    {
        // 1. Ambil token API yang disimpan di session setelah login
        $token = Session::get('api_token');
        if (!$token) {
            // Jika tidak ada token, mungkin redirect ke halaman login
            return redirect('/login')->withErrors('You are not logged in.');
        }

        // 2. Tentukan URL endpoint API di backend
        $apiUrl = env('API_URL') . '/illustrator/listings';

        // 3. Panggil API menggunakan metode dari BaseController
        $response = $this->getApi($apiUrl, $token);

        // 4. Proses respons dari API
        if ($response->successful()) {
            // Ambil data dari body JSON. Sesuai format HttpResponse Anda, data ada di dalam key 'data'.
            $arts = $response->json()['data'];

            // Kirim data ke view seperti biasa
            return view('listings', compact('arts'));
        } else {
            // Jika API gagal (misal: token tidak valid, server error), tangani errornya.
            // Anda bisa menampilkan pesan error atau redirect.
            $error = $response->json()['message'] ?? 'Failed to fetch listings from API.';
            return back()->withErrors($error);
        }
    }

    public function showCollections()
    {
        // 1. Siapkan URL ke API backend
        $apiUrl = env('API_URL') . '/collections';

        // 2. Ambil token autentikasi dari session (diasumsikan disimpan saat login)
        $token = session('api_token');
        if (!$token) {
            // Jika tidak ada token, redirect ke halaman login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 3. Panggil API menggunakan helper dari BaseController
        $response = $this->getApi($apiUrl, $token);

        $arts = []; // Default data kosong

        // 4. Proses response dari API
        if ($response->successful()) {
            // Ambil data dari body response JSON
            // Sesuai struktur HttpResponse, data ada di dalam kunci 'data'
            $arts = $response->json()['data'];
            
        } else {
            // Jika gagal, catat error untuk debugging dan tampilkan halaman dengan data kosong
            Log::error('Gagal mengambil data koleksi dari API', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Anda bisa menambahkan pesan error ke view
            return view('collections', [
                'arts' => $arts,
                'error' => 'Gagal memuat koleksi Anda saat ini.'
            ]);
        }

        // 5. Kirim data yang sudah didapat dari API ke view
        return view('collections', compact('arts'));
    }

    public function showHistories()
    {
        // 1. Ambil API Token yang disimpan di session setelah login
        $token = Session::get('api_token');

        if (!$token) {
            // Jika tidak ada token, redirect ke halaman login
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // 2. Tentukan URL endpoint API di backend
        $apiUrl = env('API_URL') . '/histories';

        // 3. Panggil API menggunakan method getApi dari Base Controller
        $response = $this->getApi($apiUrl, $token);

        // 4. Proses response dari API
        if ($response->successful()) {
            // Ambil data dari body response
            $apiData = $response->json();
            $arts = $apiData['data']; // Sesuai struktur HttpResponse trait Anda

            // 5. Kirim data ke view
            return view('histories', compact('arts'));
        } else {
            // Jika gagal (misal: token expired, server error), tampilkan halaman error
            // Anda bisa log errornya untuk debugging
            // Log::error('API Error: ' . $response->body());
            return view('histories', ['message' => 'Gagal memuat riwayat pembelian.']);
        }
    }

    public function showProfile($id)
    {
        // 1. Buat URL lengkap ke API backend
        $apiUrl = env('API_URL') . '/users/' . $id;

        // 2. Panggil API
        $response = $this->getApi($apiUrl);

        // 3. Periksa apakah panggilan API gagal
        if ($response->failed()) {
            abort($response->status(), 'Gagal mengambil data profil dari API.');
        }

        // 4. Ambil data dari body respons JSON
        $apiDataAsArray = $response->json()['data'];

        // ===== LANGKAH PERBAIKAN DI SINI =====
        // Konversi seluruh array menjadi objek secara rekursif (mendalam)
        $dataObject = json_decode(json_encode($apiDataAsArray));
        // =====================================

        // 5. Ekstrak data yang dibutuhkan dari objek yang sudah dikonversi
        $user = $dataObject->user;
        $artCount = $dataObject->art_count;
        $openCommision = $dataObject->is_open_commision;

        // 6. Kirim data ke view. Variabel sudah dalam bentuk objek.
        return view('profile', compact('user', 'artCount', 'openCommision'));
    }
}

