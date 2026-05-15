<?php

use Livewire\Volt\Component;
use App\Models\Complaint;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Complaint $complaint;
    public string $body = '';

    public function mount(Complaint $complaint)
    {
        // Memuat komentar beserta data user pengirimnya
        $this->complaint = $complaint->load('comments.user');
    }

    public function saveComment()
    {
        $this->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'complaint_id' => $this->complaint->id,
            'user_id' => Auth::id(),
            'body' => $this->body,
        ]);

        $this->body = ''; // Kosongkan input setelah mengirim
        
        // Refresh data komentar
        $this->complaint->load('comments.user');
    }
}; ?>

<div x-data="{ open: false }" class="mt-5 border-t border-gray-100 pt-5 w-full">
    
    <button @click="open = !open" type="button" class="flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-[#0A4D40] transition-colors group w-full">
        <div class="p-2 bg-gray-50 rounded-xl group-hover:bg-[#0A4D40]/10 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </div>
        Ruang Diskusi <span class="bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full text-[10px]">{{ $complaint->comments->count() }}</span>
        
        <svg class="w-4 h-4 ml-auto transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>

    <div x-show="open" x-collapse style="display: none;" class="mt-4 bg-gray-50 rounded-2xl p-4 border border-gray-100">
        
        <div class="space-y-4 max-h-64 overflow-y-auto mb-4 pr-2">
            @forelse($complaint->comments as $comment)
                <div class="flex gap-3 {{ $comment->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                    <div class="w-8 h-8 rounded-full bg-[#0A4D40] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    
                    <div class="{{ $comment->user_id === Auth::id() ? 'bg-[#0A4D40] text-white rounded-tl-2xl rounded-tr-2xl rounded-bl-2xl' : 'bg-white text-gray-700 border border-gray-200 rounded-tl-2xl rounded-tr-2xl rounded-br-2xl' }} px-4 py-2.5 shadow-sm max-w-[85%]">
                        <div class="flex justify-between items-end gap-4 mb-1">
                            <span class="text-[10px] font-black tracking-wide {{ $comment->user_id === Auth::id() ? 'text-teal-200' : 'text-gray-900' }}">
                                {{ $comment->user_id === Auth::id() ? 'Anda' : explode(' ', $comment->user->name)[0] }}
                                @if($comment->user->role === 'admin') <span class="text-rose-500 ml-1">(Admin)</span> @endif
                            </span>
                            <span class="text-[9px] {{ $comment->user_id === Auth::id() ? 'text-teal-400' : 'text-gray-400' }} whitespace-nowrap">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm leading-relaxed">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <p class="text-sm font-bold text-gray-500">Belum ada diskusi.</p>
                    <p class="text-xs text-gray-400">Silakan tinggalkan pesan untuk teknisi atau pelapor.</p>
                </div>
            @endforelse
        </div>

        <form wire:submit="saveComment" class="flex gap-2">
            <input type="text" wire:model="body" placeholder="Tulis balasan Anda di sini..." class="flex-1 rounded-full border-gray-200 text-sm focus:ring-[#0A4D40] focus:border-[#0A4D40] py-2.5 px-5 shadow-sm" autocomplete="off" required>
            <button type="submit" class="bg-[#0A4D40] text-white p-3 rounded-full hover:bg-[#06382e] transition-colors shadow-sm shrink-0">
                <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </form>
    </div>
</div>