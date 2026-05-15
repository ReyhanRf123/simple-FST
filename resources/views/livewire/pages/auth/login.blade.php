<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // LOGIKA REDIRECT DINAMIS BERDASARKAN ROLE
        if (Auth::user()->role === 'admin') {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
        } else {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }
    }
}; ?>

<div class="flex h-screen w-full font-sans">
    
    <div class="hidden md:flex w-1/2 bg-[#064e3b] text-white flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="absolute h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="1"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"></rect>
            </svg>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-16">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                <span class="text-xl font-semibold tracking-wider">UIN Syarif Hidayatullah Jakarta</span>
            </div>

            <h1 class="text-5xl font-serif font-bold leading-tight mb-6">
                Fasilitas Prima,<br>Kampus Sejahtera
            </h1>
            <p class="text-teal-100 text-lg max-w-md leading-relaxed">
                Sistem Pengaduan Fasilitas Kampus (SIMPEL-FST). Laporkan masalah, lacak perbaikan, dan wujudkan lingkungan akademik yang lebih baik bersama-sama.
            </p>
        </div>

        <div class="relative z-10 text-sm text-teal-200">
            &copy; {{ date('Y') }} Fakultas Sains dan Teknologi. All rights reserved.
        </div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center bg-[#fafaf9] p-8">
        <div class="w-full max-w-md">
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h2>
                <p class="text-gray-500">Silakan masuk menggunakan kredensial akademik Anda.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="mb-8 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-2xl flex items-start gap-3 relative overflow-hidden transition-all">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500 rounded-r-full"></div>
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div class="flex-1">
                        <p class="text-sm font-bold">Autentikasi Gagal!</p>
                        <p class="text-xs mt-0.5 opacity-90">Email atau password yang Anda masukkan salah atau tidak terdaftar.</p>
                    </div>
                    <button type="button" @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-6">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Universitas</label>
                    <input wire:model="form.email" id="email" type="email" required autofocus autocomplete="username" 
                        class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#064e3b] focus:ring-0 px-0 py-2 transition-colors">
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input wire:model="form.password" id="password" :type="showPassword ? 'text' : 'password'" required autocomplete="current-password" 
                            class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#064e3b] focus:ring-0 px-0 py-2 pr-10 transition-colors">
                        
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#064e3b] transition-colors focus:outline-none">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-[#064e3b] focus:ring-[#064e3b]">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm font-medium text-gray-600 hover:text-[#064e3b] hover:underline transition-colors" href="{{ route('password.request') }}" wire:navigate>
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-[#064e3b] hover:bg-[#064e3b]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e3b] transition-colors mt-8">
                    Login Sistem
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>