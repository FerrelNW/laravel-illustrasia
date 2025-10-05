<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Illustration;
use App\Models\Illustrator;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.layouts.main');
    }

    public function showLogin()
    {
        return view('admin.login');
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $userFromGoogle = Socialite::driver('google')->stateless()->user();

            // 1. Siapkan data dan URL untuk dikirim ke backend
            $backendUrl = env('API_URL') . '/admin/check-email';
            $data = [
                'email' => $userFromGoogle->getEmail(),
                'name' => $userFromGoogle->getName(),
                'avatar' => $userFromGoogle->getAvatar(), 
            ];

            // 2. Panggil API backend menggunakan method dari Base Controller
            $response = $this->postApi($backendUrl, $data);

            // 3. Proses respons dari backend
            if ($response->successful()) {
            // Ambil data dari respons API
                $apiData = $response->json('data');

                // SIMPAN SEMUA DATA YANG DIPERLUKAN, TERUTAMA TOKEN!
                Session::put('api_token', $apiData['token']); 
                Session::put('email', $apiData['user']['email']);
                Session::put('name', $apiData['user']['name']);
                
                // Hapus dd() dan kembalikan redirect
                return redirect()->route('admin.index')->with('success', 'Logged in!');
            } else {
                $errorMessage = $response->json('message', 'Unauthorized email!');
                return redirect()->route('admin.login')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            // Menangani error jika API backend tidak bisa dihubungi atau error lainnya
            return redirect()->route('admin.login')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        // Ambil token dari session atau tempat Anda menyimpannya
        $token = Session::get('api_token');

        // Panggil API logout di backend
        $backendUrl = env('API_URL') . '/admin/logout';
        $this->postApi($backendUrl, [], $token); // Menggunakan method postApi dari BaseController

        // Setelah token dicabut di backend, bersihkan sesi di frontend
        Session::flush();

        return redirect()->route('admin.login')->with('success', 'Logged out!');
    }

    public function showCustomers()
    {
        $customers = []; // Siapkan array kosong sebagai default
        
        // Asumsi Anda menyimpan token di session setelah admin berhasil login
        $token = Session::get('api_token'); 

        // Jika tidak ada token, kembalikan ke halaman login
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        try {
            // 1. Tentukan URL endpoint di backend
            $url = env('API_URL') . '/customers';

            // 2. Panggil API menggunakan helper dari Base Controller
            $response = $this->getApi($url, $token);

            // 3. Proses respons dari backend
            if ($response->successful()) {
                // Jika sukses, ambil array 'data' dari body JSON
                $customersData = $response->json('data');

                // Konversi array asosiatif menjadi objek agar view tidak perlu diubah
                $customers = json_decode(json_encode($customersData));
                
            } else {
                // Jika API merespons dengan error (misal: 401, 403, 500)
                $errorMessage = $response->json('message', 'Failed to fetch customer data.');
                return back()->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            // Menangani jika koneksi ke API gagal (misal: backend mati)
            return back()->with('error', 'Could not connect to the data service. ' . $e->getMessage());
        }

        // 4. Kirim data yang sudah didapat ke view
        return view('admin.customers', compact('customers'));
    }
    public function showIllustrators()
    {
        $illustrators = []; // Siapkan array kosong sebagai default
        
        $token = Session::get('api_token'); // Ambil token dari session

        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        try {
            // 1. Tentukan URL endpoint di backend
            $url = env('API_URL') . '/illustrators';

            // 2. Panggil API menggunakan helper dari Base Controller
            $response = $this->getApi($url, $token);

            // 3. Proses respons dari backend
            if ($response->successful()) {
                // Ambil array 'data' dari body JSON
                $illustratorsData = $response->json('data');

                // Konversi array menjadi objek agar view tidak perlu diubah
                $illustrators = json_decode(json_encode($illustratorsData));
                
            } else {
                // Handle API errors
                $errorMessage = $response->json('message', 'Failed to fetch illustrator data.');
                return back()->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            // Handle jika koneksi ke API gagal
            return back()->with('error', 'Could not connect to the data service. ' . $e->getMessage());
        }

        // 4. Kirim data yang sudah didapat ke view
        return view('admin.illustrators', compact('illustrators'));
    }

    public function deleteUser($id)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            // Tentukan URL lengkap ke endpoint delete di backend
            $url = env('API_URL') . '/users/' . $id;

            // Panggil API menggunakan helper baru kita
            $response = $this->deleteApi($url, $token);

            if ($response->successful()) {
                // Jika sukses, ambil pesan dari respons API
                $message = $response->json('message', 'User deleted!');
                return redirect()->back()->with('success', $message);
            } else {
                // Jika gagal, ambil pesan error dari respons API
                $message = $response->json('message', 'Failed to delete user.');
                return redirect()->back()->with('error', $message);
            }
        } catch (\Exception $e) {
            // Tangani jika koneksi ke backend gagal
            return redirect()->back()->with('error', 'Could not connect to the service: ' . $e->getMessage());
        }
    }

    public function showEditCustomer($id)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            // Tentukan URL lengkap ke endpoint di backend
            $url = env('API_URL') . '/customers/' . $id;

            // Panggil API menggunakan helper getApi
            $response = $this->getApi($url, $token);

            // Proses respons dari backend
            if ($response->successful()) {
                $customerData = $response->json('data');

                // Cek jika data kosong (misal: customer dihapus oleh admin lain)
                if (empty($customerData)) {
                    return redirect()->route('admin.customers')->with('error', 'Customer not found.');
                }
                
                // Konversi array menjadi objek agar syntax di view tidak perlu diubah
                $customer = json_decode(json_encode($customerData));

                // Kirim data customer ke view
                return view('admin.edit_customer', compact('customer'));

            } else {
                // Jika API merespons error (misal: 404 Not Found)
                $message = $response->json('message', 'Failed to fetch customer data.');
                // Arahkan kembali ke halaman daftar customer dengan pesan error
                return redirect()->route('admin.customers')->with('error', $message);
            }

        } catch (\Exception $e) {
            // Tangani jika koneksi ke backend gagal
            return redirect()->route('admin.customers')->with('error', 'Could not connect to the data service.');
        }
    }

    public function showEditIllustrator($id)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            // Tentukan URL lengkap ke endpoint di backend
            $url = env('API_URL') . '/illustrators/' . $id;

            // Panggil API menggunakan helper getApi
            $response = $this->getApi($url, $token);

            // Proses respons dari backend
            if ($response->successful()) {
                $illustratorData = $response->json('data');

                if (empty($illustratorData)) {
                    return redirect()->route('admin.illustrators')->with('error', 'Illustrator not found.');
                }
                
                // Konversi array menjadi objek agar syntax di view tidak perlu diubah
                $illustrator = json_decode(json_encode($illustratorData));

                // Kirim data illustrator ke view
                return view('admin.edit_illustrator', compact('illustrator'));

            } else {
                // Jika API merespons error (misal: 404 Not Found)
                $message = $response->json('message', 'Failed to fetch illustrator data.');
                // Arahkan kembali ke halaman daftar illustrator dengan pesan error
                return redirect()->route('admin.illustrators')->with('error', $message);
            }

        } catch (\Exception $e) {
            // Tangani jika koneksi ke backend gagal
            return redirect()->route('admin.illustrators')->with('error', 'Could not connect to the data service.');
        }
    }

    public function editCustomer(Request $request, $id)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        // Kumpulkan data dari form, tanpa validasi di sini
        $dataToUpdate = $request->only(['name', 'email', 'bio']);
        
        try {
            // Tentukan URL lengkap ke endpoint update di backend
            $url = env('API_URL') . '/editCustomer/' . $id;

            // Panggil API menggunakan helper baru kita
            $response = $this->putApi($url, $dataToUpdate, $token);

            if ($response->successful()) {
                // Jika sukses, arahkan ke daftar customer
                $message = $response->json('message', 'Customer updated!');
                return redirect()->route('admin.customers')->with('success', $message);
            } else {
                // Jika gagal (misal: validasi error), kembali ke halaman sebelumnya
                // dengan pesan error dari API dan input yang lama.
                $message = $response->json('message', 'Update failed. Please check the data.');
                return redirect()->back()->with('error', $message)->withInput();
            }

        } catch (\Exception $e) {
            // Tangani jika koneksi ke backend gagal
            return redirect()->back()->with('error', 'Could not connect to the update service.')->withInput();
        }
    }

    public function editIllustrator(Request $request, $id)
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        // Kumpulkan semua data yang relevan dari form
        $dataToUpdate = $request->only([
            'name', 'email', 'bio', 'experience_years', 'portofolio_link', 'is_open_commision'
        ]);
        
        try {
            // Tentukan URL lengkap ke endpoint update di backend
            $url = env('API_URL') . '/editIllustrator/' . $id;

            // Panggil API menggunakan helper `putApi`
            $response = $this->putApi($url, $dataToUpdate, $token);

            if ($response->successful()) {
                // Jika sukses, arahkan ke daftar illustrator
                $message = $response->json('message', 'Illustrator updated!');
                return redirect()->route('admin.illustrators')->with('success', $message);
            } else {
                // Jika gagal, kembali ke halaman sebelumnya dengan error dan input lama
                $message = $response->json('message', 'Update failed. Please check the data.');
                return redirect()->back()->with('error', $message)->withInput();
            }

        } catch (\Exception $e) {
            // Tangani jika koneksi ke backend gagal
            return redirect()->back()->with('error', 'Could not connect to the update service.')->withInput();
        }
    }

    public function showPurchases()
    {
        $purchases = []; // Default ke array kosong
        $token = Session::get('api_token');

        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            $url = env('API_URL') . '/purchases';
            $response = $this->getApi($url, $token); // Gunakan helper yang sudah ada

            if ($response->successful()) {
                $purchasesData = $response->json('data');
                // Trik yang sama untuk memastikan view tidak perlu diubah
                $purchases = json_decode(json_encode($purchasesData));
            } else {
                $message = $response->json('message', 'Failed to fetch purchase data.');
                return back()->with('error', $message);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Could not connect to the data service.');
        }

        // Kirim data yang sudah didapat ke view
        return view('admin.purchases', compact('purchases'));
    }

    public function verifyPurchase($id) // Mengambil $id dari route
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            // URL menunjuk ke endpoint 'verify' yang spesifik
            $url = env('API_URL') . '/purchases/' . $id . '/verify';

            // Gunakan postApi dengan data kosong karena aksi sudah ditentukan oleh URL
            $response = $this->postApi($url, [], $token);

            if ($response->successful()) {
                $message = $response->json('message', 'Purchase verified!');
                return redirect()->route('admin.purchases')->with('success', $message);
            } else {
                $message = $response->json('message', 'Verification failed.');
                return redirect()->route('admin.purchases')->with('error', $message);
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.purchases')->with('error', 'Could not connect to the service.');
        }
    }

    public function rejectPurchase($id) // Mengambil $id dari route
    {
        $token = Session::get('api_token');
        if (!$token) {
            return redirect()->route('admin.login')->with('error', 'Authentication required.');
        }

        try {
            // URL menunjuk ke endpoint 'reject' yang spesifik
            $url = env('API_URL') . '/purchases/' . $id . '/reject';

            // Gunakan postApi dengan data kosong
            $response = $this->postApi($url, [], $token);

            if ($response->successful()) {
                $message = $response->json('message', 'Purchase rejected!');
                return redirect()->route('admin.purchases')->with('success', $message);
            } else {
                $message = $response->json('message', 'Rejection failed.');
                return redirect()->route('admin.purchases')->with('error', $message);
            }

        } catch (\Exception $e) {
            return redirect()->route('admin.purchases')->with('error', 'Could not connect to the service.');
        }
    }
}
