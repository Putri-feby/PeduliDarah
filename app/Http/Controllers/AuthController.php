<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DonorProfile;
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        \App\Models\Pmi::firstOrCreate(['name' => 'PMI Tangerang Selatan']);
        \App\Models\Pmi::firstOrCreate(['name' => 'PMI Kota Tangerang Selatan']);
        $pmis = \App\Models\Pmi::orderBy('name')->get();
        return view('auth.registrasi_user', compact('pmis'));
    }

    public function register(Request $request)
    {
        // Common validation for all users
        $rules = [
            'role' => 'required|in:donor,staff',
            'nama_lengkap' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|string|email|max:255|unique:users',
            'no_telp' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:11', 'max:15', 'unique:users,no_telp'],
            'jenis_kelamin' => 'required|in:pria,wanita',
            'nik' => 'required|string|digits:16|unique:users,nik',
            'tanggal_lahir' => 'required|date|before_or_equal:-17 years|after_or_equal:-70 years',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Role-specific validation
        if ($request->role === 'donor') {
            $rules['golongan_darah'] = 'required|in:A,B,AB,O';
            $rules['rhesus'] = 'required|in:+,-';
            $rules['riwayat_penyakit'] = 'nullable|string';
            $rules['pernah_donor'] = 'required|boolean';
            $rules['detail_riwayat_donor'] = 'nullable|string';
            $rules['alergi'] = 'nullable|string';
            $rules['obat'] = 'nullable|string';
        } elseif ($request->role === 'staff') {
            $rules['unit_pmi'] = 'required|string|max:255';
            $rules['nomor_pegawai'] = 'required|string|max:50';
            $rules['foto_id_card'] = 'required|image|mimes:jpeg,png,jpg|max:5120';
        }

        $messages = [
            'nama_lengkap.required' => 'Nama Lengkap wajib diisi.',
            'nama_lengkap.regex' => 'Nama Lengkap hanya boleh berisi huruf dan spasi.',
            'nama_lengkap.min' => 'Nama Lengkap minimal 2 karakter.',
            'nama_lengkap.max' => 'Nama Lengkap maksimal 100 karakter.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Usia minimal untuk mendaftar adalah 17 tahun.',
            'tanggal_lahir.after_or_equal' => 'Usia maksimal untuk mendaftar adalah 70 tahun.',
            'no_telp.required' => 'Nomor Telepon wajib diisi.',
            'no_telp.regex' => 'Nomor Telepon hanya boleh berisi angka.',
            'no_telp.min' => 'Nomor Telepon minimal 11 digit.',
            'no_telp.max' => 'Nomor Telepon maksimal 15 digit.',
            'no_telp.unique' => 'Nomor Telepon telah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ];

        $validator = validator()->make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessages = [];
            
            foreach ($errors->all() as $error) {
                $errorMessages[] = $error;
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $errorMessages,
                    'all_errors' => $errors->toArray()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create user in users table
        $user = User::create([
            'role' => $request->role,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password' => Hash::make($request->password),
        ]);

        // Create profile based on role
        if ($request->role === 'donor') {
            DonorProfile::create([
                'user_id' => $user->id,
                'golongan_darah' => $request->golongan_darah,
                'rhesus' => $request->rhesus,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'pernah_donor' => $request->pernah_donor,
                'detail_riwayat_donor' => $request->detail_riwayat_donor,
                'alergi' => $request->alergi,
                'obat' => $request->obat,
            ]);
        } elseif ($request->role === 'staff') {
            // Handle file upload for staff ID card
            $fotoIdCardPath = null;
            if ($request->hasFile('foto_id_card')) {
                $fotoIdCardPath = $request->file('foto_id_card')->store('staff_id_cards', 'public');
            }

            StaffProfile::create([
                'user_id' => $user->id,
                'unit_pmi' => $request->unit_pmi,
                'nomor_pegawai' => $request->nomor_pegawai,
                'foto_id_card' => $fotoIdCardPath,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login untuk masuk.',
                'email' => $user->email
            ]);
        }

        return redirect()->route('login')
            ->with('success', 'Akun Anda berhasil terdaftar! Silakan login.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Check if user exists
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // Check if account is locked
        if ($user->locked_until && now()->lt($user->locked_until)) {
            $remainingTime = now()->diffInMinutes($user->locked_until);
            return back()->withErrors([
                'email' => "Akun Anda terkunci sementara. Silakan coba lagi dalam {$remainingTime} menit.",
            ])->onlyInput('email');
        }

        // Attempt login
        if (Auth::attempt($credentials)) {
            // Reset login attempts on successful login
            $user->update([
                'login_attempts' => 0,
                'locked_until' => null,
            ]);

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // Increment login attempts on failed login
        $user->increment('login_attempts');

        // Lock account if 3 failed attempts
        if ($user->login_attempts >= 3) {
            $user->update([
                'locked_until' => now()->addMinutes(15),
            ]);

            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login gagal. Akun Anda terkunci selama 15 menit.',
            ])->onlyInput('email');
        }

        $remainingAttempts = 3 - $user->login_attempts;
        return back()->withErrors([
            'email' => "Email atau password salah. Percobaan tersisa: {$remainingAttempts}",
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
