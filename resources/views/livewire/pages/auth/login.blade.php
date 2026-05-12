<?php

use App\Livewire\Forms\LoginForm;
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

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<x-guest-layout>
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
                    <span class="text-xl font-semibold tracking-wider">Universitas</span>
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

                <form wire:submit="login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Username atau Email</label>
                        <input wire:model="form.email" id="email" type="email" required autofocus autocomplete="username" 
                            class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#064e3b] focus:ring-0 px-0 py-2 transition-colors">
                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input wire:model="form.password" id="password" type="password" required autocomplete="current-password" 
                            class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#064e3b] focus:ring-0 px-0 py-2 transition-colors">
                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember" class="inline-flex items-center">
                            <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-[#064e3b] focus:ring-[#064e3b]">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-[#064e3b] hover:underline" href="{{ route('password.request') }}" wire:navigate>
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-[#064e3b] hover:bg-[#064e3b]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#064e3b] transition-colors mt-8">
                        Login
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <div class="mt-6 relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-[#fafaf9] text-gray-500">atau</span>
                        </div>
                    </div>

                    <button type="button" class="mt-6 w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-full shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                        SSO Universitas
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
