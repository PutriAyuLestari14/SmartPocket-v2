<?php

namespace App\Http\Requests\Auth;

use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Pesan error jika field kosong
     */
    public function messages(): array
    {
        return [
            'username.required' => 'Nomor Rekening / Username wajib diisi.',
            'username.string'   => 'Nomor Rekening / Username harus berupa teks.',
            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Password harus berupa teks.',
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->string('username')->toString();
        $password = $this->string('password')->toString();

        // ================================================================
        // SKENARIO A: Input berupa No Rekening (nasabah)
        // ================================================================
        $nasabah = Nasabah::where('no_rek', $login)->first();

        if ($nasabah) {
            // Cek dulu apakah nasabah punya akun user
            if (! $nasabah->user) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username' => 'Akun nasabah tidak ditemukan. Silakan hubungi operator.',
                ]);
            }

            // Cek password secara manual biar bisa bedakan username vs password
            if (! Hash::check($password, $nasabah->user->password)) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'password' => 'Password salah. Silakan coba lagi.',
                ]);
            }

            // ✅ Password benar → login
            Auth::login($nasabah->user, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // ================================================================
        // SKENARIO B: Input berupa Username (admin/operator)
        // ================================================================
        $user = User::where('username', $login)->first();

        // Username ada di database
        if ($user) {
            // Cek rolenya (hanya admin/operator yang boleh login lewat sini)
            if (! in_array($user->role, ['admin', 'operator'])) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username' => 'Akun ini tidak memiliki akses untuk login.',
                ]);
            }

            // Cek password
            if (! Hash::check($password, $user->password)) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'password' => 'Password salah. Silakan coba lagi.',
                ]);
            }

            // ✅ Password benar → login
            Auth::login($user, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // ================================================================
        // SKENARIO C: Username / No Rekening tidak ditemukan
        // ================================================================
        RateLimiter::hit($this->throttleKey());
        throw ValidationException::withMessages([
            'username' => 'Nomor Rekening / Username tidak terdaftar. Periksa kembali.',
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => 'Terlalu banyak percobaan login. Akun Anda terkunci sementara. Silakan coba lagi dalam ' . ceil($seconds / 60) . ' menit.',
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('username')) . '|' . $this->ip()
        );
    }
}