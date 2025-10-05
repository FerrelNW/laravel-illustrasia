<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Illustrator;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegisterCustomer()
    {
        return view('auth.register.customer');
    }

    public function showRegisterIllustrator()
    {
        return view('auth.register.illustrator');
    }

    public function showLoginCustomer()
    {
        return view('auth.login.customer');
    }

    public function showLoginIllustrator()
    {
        return view('auth.login.illustrator');
    }

    public function registerCustomer(Request $request)
    {
        // 1. Validasi request di frontend (termasuk validasi file)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Validasi unique akan ditangani oleh API
            'password' => 'required|string|min:8',
            'bio' => 'required|string|max:500',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Simpan file di storage frontend
        // Perintah ini akan menyimpan file di storage/app/public/profile_pictures
        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');

        // 3. Panggil API backend dengan data yang sudah disiapkan
        $response = Http::post(env('API_URL') . '/register/customer', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio,
            'profile_picture' => 'storage/' . $profilePicturePath, // Kirim path-nya sebagai string
        ]);

        // 4. Tangani respons dari API
        if ($response->failed()) {
            // Jika API mengembalikan error (misal: email sudah terdaftar), kembali dengan error
            return redirect()->back()->withInput()->with('error', $response->json()['message'] ?? 'An error occurred.');
        }

        // Jika berhasil, redirect ke halaman login
        return redirect()->route('login.customer')->with('success', 'Account created successfully!');
    }

    public function registerIllustrator(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'bio' => 'required|string|max:500',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'experience_years' => 'required|integer',
            'portofolio_link' => 'nullable|url',
        ]);

        $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        
        $response = Http::post(env('API_URL') . '/register/illustrator', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'bio' => $request->bio,
            'profile_picture' => 'storage/' . $profilePicturePath,
            'experience_years' => $request->experience_years,
            'portofolio_link' => $request->portofolio_link,
            'is_open_commision' => $request->boolean('is_open_commision'),
        ]);

        if ($response->failed()) {
            return redirect()->back()->withInput()->with('error', $response->json()['message'] ?? 'An error occurred.');
        }

        return redirect()->route('login.illustrator')->with('success', 'Account created!');
    }

    public function loginCustomer(Request $request)
    {
        // 1. Validasi awal
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Panggil API backend untuk login
        $response = $this->postApi(env('API_URL') . '/login/customer', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // 3. Tangani response dari API
        if ($response->successful()) {
            $data = $response->json('data');

            // PASTIKAN ANDA MENYIMPAN SEMUA INI
            Session::put('api_token', $data['token']);
            Session::put('user_id', $data['user']['id']); // <-- INI YANG PALING PENTING
            Session::put('name', $data['user']['name']);
            Session::put('profile_picture', $data['user']['profile_picture']);
            Session::put('customer_id', $data['user']['customer']['id']);

            return redirect()->route('home')->with('success', 'Login successful!');
        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error dari API
            return back()->with('error', $response->json('message', 'Login failed. Please try again.'))->withInput();
        }
    }

    public function loginIllustrator(Request $request)
    {
        // 1. Validasi awal
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Panggil API backend untuk login
        $response = $this->postApi(env('API_URL') . '/login/illustrator', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // 3. Tangani response dari API
        if ($response->successful()) {
            $data = $response->json('data');

            // SIMPAN SEMUA DATA YANG DIPERLUKAN SECARA KONSISTEN
            Session::put('api_token', $data['token']); 
            Session::put('user_id', $data['user']['id']); // <-- TAMBAHKAN BARIS INI
            Session::put('name', $data['user']['name']);
            Session::put('profile_picture', $data['user']['profile_picture']);
            Session::put('illustrator_id', $data['illustrator_id']); // Ini tetap disimpan untuk membedakan peran

            // Redirect ke home
            return redirect()->route('home')->with('success', 'Login successful!');
        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error dari API
            return back()->with('error', $response->json('message', 'Login failed. Please try again.'))->withInput();
        }
    }

    public function logout()
    {
        $token = session('api_token');
        
        if ($token) {
            $apiUrl = env('API_URL') . '/logout';
            // Anda bisa gunakan Http::withToken langsung atau helper postApi
            $response = Http::withToken($token)->post($apiUrl);

            // Jika karena suatu alasan API gagal, kita tetap ingin logout dari frontend
            if ($response->failed()) {
                // Hancurkan sesi lokal sebagai fallback
                session()->flush();
                // Beri pesan yang sedikit berbeda agar tahu ada masalah
                return redirect()->route('home')->with('error', 'Could not confirm logout with server, but you have been logged out locally.');
            }
        }

        // Hancurkan sesi lokal setelah berhasil (atau jika tidak ada token sama sekali)
        session()->flush();
        
        return redirect()->route('home')->with('success', 'You have been successfully logged out!');
    }
}
