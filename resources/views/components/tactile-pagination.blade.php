@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex items-center justify-between gap-2">
        <!-- Info Ringkas -->
        <div class="hidden sm:block text-xs font-bold text-[#71717A]">
            Menampilkan <span class="text-[#18181B]">{{ $paginator->firstItem() }}</span> sampai <span class="text-[#18181B]">{{ $paginator->lastItem() }}</span> dari <span class="text-[#18181B]">{{ $paginator->total() }}</span> data
        </div>

        <!-- Tombol Pagination Kotak Bergaris Taktil -->
        <div class="flex items-center gap-1.5 flex-wrap">
            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#E4E4E7] text-[#A1A1AA] cursor-not-allowed bg-[#FFFFFF] shadow-[1px_1px_0px_#E4E4E7]">
                    <i class="bi bi-chevron-left text-xs font-bold"></i>
                </span>
            @else
                <a 
                    href="{{ $paginator->previousPageUrl() }}" 
                    rel="prev" 
                    class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#18181B] text-[#18181B] bg-[#FFFFFF] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    <i class="bi bi-chevron-left text-xs font-bold"></i>
                </a>
            @endif

            {{-- Elemen Nomor Halaman --}}
            @foreach ($elements as $element)
                {{-- Pemisah "Three Dots" --}}
                @if (is_string($element))
                    <span class="w-9 h-9 flex items-center justify-center text-xs font-bold text-[#71717A]">{{ $element }}</span>
                @endif

                {{-- Array Tautan Nomor --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#18181B] bg-[#18181B] text-[#FAF8F5] text-xs font-extrabold shadow-[2px_2px_0px_#18181B] cursor-default">
                                {{ $page }}
                            </span>
                        @else
                            <a 
                                href="{{ $url }}" 
                                class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#18181B] bg-[#FFFFFF] text-[#18181B] text-xs font-bold shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <a 
                    href="{{ $paginator->nextPageUrl() }}" 
                    rel="next" 
                    class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#18181B] text-[#18181B] bg-[#FFFFFF] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    <i class="bi bi-chevron-right text-xs font-bold"></i>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-lg border-2 border-[#E4E4E7] text-[#A1A1AA] cursor-not-allowed bg-[#FFFFFF] shadow-[1px_1px_0px_#E4E4E7]">
                    <i class="bi bi-chevron-right text-xs font-bold"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
