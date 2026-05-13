<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            session()->flash('status', __($status));

            $this->redirectRoute('login', navigate: true);
        } else {
            $this->addError('email', __($status));
        }
    }
}; ?>

<div class="flex h-screen w-full font-sans">
    
    <div class="hidden md:flex w-1/2 bg-[#0A4D40] text-white flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="absolute h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="reset-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="1"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#reset-grid)"></rect>
            </svg>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-16">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                <span class="text-xl font-semibold tracking-wider">Universitas</span>
            </div>

            <h1 class="text-5xl font-serif font-bold leading-tight mb-6">
                Keamanan Akun<br>Terjaga Kembali
            </h1>
            <p class="text-teal-100 text-lg max-w-md leading-relaxed">
                Langkah terakhir untuk mendapatkan kembali akses Anda. Silakan tentukan kata sandi baru yang kuat untuk melindungi data akademik Anda.
            </p>
        </div>

        <div class="relative z-10 text-sm text-teal-200/60">
            &copy; {{ date('Y') }} Fakultas Sains dan Teknologi. All rights reserved.
        </div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center bg-[#FAFAFA] p-8">
        <div class="w-full max-w-md">
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Reset Password</h2>
                <p class="text-gray-500 text-sm leading-relaxed">Buat kata sandi baru yang unik untuk melanjutkan akses ke layanan SIMPEL-FST.</p>
            </div>

            <form wire:submit="resetPassword" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Akademik</label>
                    <input wire:model="email" id="email" type="email" name="email" required readonly
                        class="mt-1 block w-full border-0 border-b-2 border-gray-200 bg-gray-50 text-gray-400 px-0 py-2 transition-colors cursor-not-allowed">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input wire:model="password" id="password" type="password" name="password" required autofocus autocomplete="new-password"
                        class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#0A4D40] focus:ring-0 px-0 py-2 transition-colors">
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                    <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#0A4D40] focus:ring-0 px-0 py-2 transition-colors">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 rounded-full shadow-sm text-sm font-bold text-white bg-[#0A4D40] hover:bg-[#06382e] transition-colors">
                        Simpan & Perbarui Password
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>