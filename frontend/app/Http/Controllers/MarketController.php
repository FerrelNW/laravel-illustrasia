<?php

namespace App\Http\Controllers;

use App\Models\Category;

use App\Models\Illustration;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class MarketController extends Controller
{
    public function index()
    {
        // 1. Tentukan URL endpoint API di backend
        $apiUrl = env('API_URL') . '/market/illustrations';

        // 2. Lakukan panggilan GET ke API menggunakan method dari BaseController Anda
        $response = $this->getApi($apiUrl);

        // 3. Cek apakah panggilan API berhasil
        if ($response->successful()) {
            // Ambil data dari body respons JSON
            $apiData = $response->json()['data']; // Kita ambil dari key 'data' sesuai format HttpResponse Anda

            // UBAH DI SINI: Konversi array menjadi objek agar konsisten
            // dengan halaman Dashboard Anda.
            $illustrations = json_decode(json_encode($apiData['illustrations']));
            $categories = json_decode(json_encode($apiData['categories']));

            // Kirim data ke view seperti biasa
            return view('market', compact('illustrations', 'categories'));

        } else {
            // Jika API gagal, catat error dan tampilkan halaman error
            Log::error('Gagal mengambil data dari API pasar', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            // Anda bisa return ke view error atau kembali dengan pesan error
            return view('market', [
                'illustrations' => [],
                'categories' => []
            ])->with('error', 'Gagal memuat data. Silakan coba lagi nanti.');
        }
    }

    public function showIllustration($id)
    {
        // 1. Bentuk URL API lengkap
        $apiUrl = env('API_URL') . '/illustrations/' . $id;

        // 2. Panggil API menggunakan helper dari BaseController
        $response = $this->getApi($apiUrl);
        
        // 3. Cek jika panggilan API berhasil (status code 2xx)
        if ($response->successful()) {
            // Ambil data dari body response
            // Response Anda memiliki format {..., "data": {...}}, jadi kita ambil isi dari 'data'
            $illustrationDataAsArray = $response->json()['data'];

            // ===== LANGKAH PERBAIKAN DI SINI =====
            // Konversi array multi-level menjadi objek multi-level
            // 1. Encode kembali ke string JSON
            $jsonString = json_encode($illustrationDataAsArray);
            // 2. Decode string JSON menjadi objek stdClass
            $artObject = json_decode($jsonString);

            // 4. Kirim data ke view
            return view('illustrations.detail', ['art' => $artObject]);
            
        } else {
            // Jika gagal (misal: 404 Not Found dari backend), tampilkan halaman error
            // Anda bisa buat view khusus untuk error atau redirect
            
            $errorCode = $response->status();
            // dd($errorCode);
            $errorMessage = $response->json()['message'] ?? 'Failed to fetch data from API.';
            // dd($response->status(), $response->json());
            // Abort helper adalah cara mudah untuk menampilkan halaman error
            abort($errorCode, $errorMessage);
        }
    }

    public function showSell()
    {
        // 1. Definisikan URL endpoint API di backend
        $apiUrl = env('API_URL') . '/categories';

        // 2. Panggil API menggunakan method dari Base Controller Anda
        $response = $this->getApi($apiUrl);

        $categories = []; // Siapkan array kosong sebagai default

        // 3. Proses response dari API
        if ($response->successful()) {
            // Jika request berhasil (status code 2xx)
            // Ambil data dari body response. Sesuai format HttpResponse Anda, data ada di dalam kunci 'data'
            $categories = $response->json()['data'];
        } else {
            // Jika request gagal, Anda bisa menambahkan log atau menampilkan pesan error
            // Untuk sekarang, kita biarkan $categories kosong agar halaman tidak error.
            \Illuminate\Support\Facades\Log::error('Failed to fetch categories from API', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Anda bisa menambahkan pesan error ke session untuk ditampilkan di view
            // session()->flash('error', 'Gagal memuat data kategori dari server.');
        }

        // 4. Kirim data yang sudah didapat dari API ke view
        return view('illustrations.sell', compact('categories'));
    }

    public function showBuy($id)
    {
        // 1. Definisikan URL endpoint API di backend, gabungkan dengan ID
        $apiUrl = env('API_URL') . '/illustrations/' . $id;

        // 2. Panggil API menggunakan method dari Base Controller Anda
        $response = $this->getApi($apiUrl);

        // 3. Proses response dari API
        if ($response->successful()) {
            // Jika request berhasil (status 2xx)
            $artData = $response->json()['data'];
            
            // Konversi array dari JSON menjadi object agar kompatibel dengan view lama Anda
            $art = (object) $artData;

            // Kirim data ke view
            return view('illustrations.buy', compact('art'));

        } elseif ($response->status() == 404) {
            // Jika API mengembalikan status 404 (Not Found)
            abort(404, 'Ilustrasi yang Anda cari tidak ditemukan.');
        } else {
            // Handle error lainnya dari API (misal: server backend down)
            \Illuminate\Support\Facades\Log::error('Failed to fetch illustration from API', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            abort(500, 'Terjadi kesalahan saat mengambil data dari server.');
        }
    }

    public function sell(Request $request)
    {
        // 1. Validasi di frontend, termasuk file
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
            'date_issued' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->back()->with('error', 'Authentication failed. Please login again.');
        }

        // 2. Simpan file di storage frontend LOKAL
        $imagePath = $request->file('image_path')->store('uploads', 'public');

        // 3. Panggil API dengan path sebagai string (bukan lagi multipart)
        $apiUrl = env('API_URL') . '/illustrations';
        $response = Http::withToken($token)->post($apiUrl, [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'date_issued' => $request->input('date_issued'),
            'category_id' => $request->input('category_id'),
            'image_path' => 'storage/' . $imagePath, // Kirim path hasil store
        ]);

        // 4. Proses respons dari backend
        if ($response->successful()) {
            return redirect()->route('market')->with('success', $response->json()['message'] ?? 'Artwork successfully listed!');
        } else {
            $errorData = $response->json();
            $errorMessage = $errorData['message'] ?? 'An error occurred while listing the artwork.';
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    }

    public function buy(Request $request)
    {
        // 1. Validasi di frontend, termasuk bukti pembayaran
        $validated = $request->validate([
            'id' => 'required|integer',
            'payment_method' => 'required',
            'file_path' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('login.customer')->with('error', 'You must be logged in.');
        }

        // 2. Simpan file bukti pembayaran di storage frontend LOKAL
        $proofPath = $request->file('file_path')->store('uploads/proofs', 'public');

        // 3. Panggil API dengan path sebagai string
        $apiUrl = env('API_URL') . '/purchase';
        $response = Http::withToken($token)->post($apiUrl, [
            'illustration_id' => $validated['id'],
            'payment_method' => $validated['payment_method'],
            'file_path' => 'storage/' . $proofPath, // Kirim path hasil store
        ]);

        // 4. Proses respons dari API
        if ($response->successful()) {
            return redirect()->route('market')->with('success', $response->json()['message']);
        } else {
            $errorData = $response->json();
            dd($response->status(), $response->json());
            $errorMessage = $errorData['message'] ?? 'An unknown error occurred.';
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    }

    public function filter(Request $request)
    {
        // 1. Ambil semua parameter dari request AJAX
        $queryParams = $request->all();

        // 2. Tentukan URL API backend
        $apiUrl = env('API_URL') . '/market/filter';

        // 3. Panggil API backend dengan parameter
        $response = Http::get($apiUrl, $queryParams);

        // 4. Cek jika berhasil dan kembalikan response JSON-nya langsung
        if ($response->successful()) {
            // Ambil dari key 'data' sesuai format HttpResponse Anda
            return response()->json($response->json('data'));
        }

        // Jika gagal, kembalikan response error
        return response()->json(['error' => 'Failed to fetch data'], $response->status());
    }
    
    // Helper untuk mengambil kategori (jika diperlukan di view yang sama)
    // private function getCategories()
    // {
    //     $response = $this->getApi(env('API_URL') . '/categories');
    //     if ($response->successful()) {
    //         return $response->json()['data'] ?? []; // Sesuaikan dengan struktur response Anda
    //     }
    //     return [];
    // }

}

