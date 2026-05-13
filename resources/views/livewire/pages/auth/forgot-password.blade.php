<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::broker()->sendResetLink(
            ['email' => $this->email]
        );

        if ($status == Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
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
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="1"></path>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)"></rect>
            </svg>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-16">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                <span class="text-xl font-semibold tracking-wider">Universitas</span>
            </div>

            <h1 class="text-5xl font-serif font-bold leading-tight mb-6">
                Pemulihan Akses<br>Akun Akademik
            </h1>
            <p class="text-teal-100 text-lg max-w-md leading-relaxed">
                Jangan khawatir jika Anda melupakan kata sandi. Masukkan email institusi Anda dan sistem kami akan segera mengirimkan tautan pemulihan.
            </p>
        </div>

        <div class="relative z-10 text-sm text-teal-200/60">
            &copy; {{ date('Y') }} Fakultas Sains dan Teknologi. All rights reserved.
        </div>
    </div>

    <div class="w-full md:w-1/2 flex items-center justify-center bg-[#FAFAFA] p-8">
        <div class="w-full max-w-md">
            
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
                <p class="text-gray-500 text-sm leading-relaxed">Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="sendPasswordResetLink" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Akademik</label>
                    <input wire:model="email" id="email" type="email" required autofocus 
                        class="mt-1 block w-full border-0 border-b-2 border-gray-300 bg-transparent focus:border-[#0A4D40] focus:ring-0 px-0 py-2 transition-colors">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500 text-xs" />
                </div>

                <div class="flex flex-col gap-4 mt-8">
                    <button type="submit" class="w-full flex justify-center items-center py-3 px-4 rounded-full shadow-sm text-sm font-bold text-white bg-[#0A4D40] hover:bg-[#06382e] transition-colors">
                        Kirim Tautan Pemulihan
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>

                    <a href="{{ route('login') }}" wire:navigate class="w-full flex justify-center items-center py-3 px-4 rounded-full border border-gray-300 shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Kembali ke Login
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>