@props([
    'name',
    'id' => null,
    'value' => '',
    'options' => [],
    'placeholder' => 'Pilih pilihan...',
    'hasError' => false,
    'searchable' => false,
    'searchPlaceholder' => 'Cari opsi...',
    'autoSubmitForm' => false,
])

@php
    $inputId = $id ?? $name;
    $selectedValue = (string) $value;
    $selectedLabel = $options[$selectedValue] ?? $selectedValue;
    if (empty($selectedLabel) && !empty($options)) {
        $selectedLabel = $placeholder;
    }
@endphp

<div class="relative w-full" data-dropdown-container @if($autoSubmitForm) data-auto-submit="true" @endif>
    {{-- Input tersembunyi untuk mengirim nilai saat submit formulir --}}
    <input 
        type="hidden" 
        name="{{ $name }}" 
        id="{{ $inputId }}" 
        value="{{ $selectedValue }}" 
        data-dropdown-input
    >

    {{-- Tombol trigger taktil --}}
    <button 
        type="button" 
        data-dropdown-trigger
        aria-haspopup="listbox" 
        aria-expanded="false" 
        aria-controls="{{ $inputId }}-options"
        class="w-full flex items-center justify-between px-3.5 py-2.5 bg-[#FFFFFF] border-2 {{ $hasError ? 'border-[#DC2626] bg-[#FEF2F2]' : 'border-[#18181B]' }} rounded-xl text-xs font-bold text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer text-left focus:outline-none"
    >
        <div class="flex items-center gap-2 truncate">
            @if ($selectedValue === 'Aktif' || $selectedValue === 'Lunas')
                <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] border border-[#18181B] shrink-0" data-dropdown-trigger-dot></span>
            @elseif ($selectedValue === 'Suspend' || $selectedValue === 'Belum Bayar')
                <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B] border border-[#18181B] shrink-0" data-dropdown-trigger-dot></span>
            @elseif ($selectedValue === 'Putus')
                <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444] border border-[#18181B] shrink-0" data-dropdown-trigger-dot></span>
            @else
                <span class="w-2.5 h-2.5 rounded-full bg-[#71717A] border border-[#18181B] shrink-0 hidden" data-dropdown-trigger-dot></span>
            @endif
            <span data-dropdown-label class="truncate text-[#18181B]">
                {{ $selectedLabel }}
            </span>
        </div>
        <i class="bi bi-chevron-down text-xs font-bold text-[#18181B] transition-transform duration-200 shrink-0 ml-2" data-dropdown-arrow></i>
    </button>

    {{-- Menu opsi melayang taktil --}}
    <div 
        id="{{ $inputId }}-options" 
        role="listbox" 
        tabindex="-1"
        data-dropdown-menu
        class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl shadow-[4px_4px_0px_#18181B] p-1.5"
    >
        {{-- Searchbar di dalam dropdown jika mode searchable aktif --}}
        @if($searchable)
            <div class="p-1 border-b-2 border-[#18181B] mb-1.5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-[#71717A]">
                        <i class="bi bi-search text-xs"></i>
                    </div>
                    <input 
                        type="text" 
                        data-dropdown-search
                        placeholder="{{ $searchPlaceholder }}"
                        autocomplete="off"
                        class="w-full pl-7 pr-2.5 py-1.5 bg-[#FAF8F5] border-2 border-[#18181B] rounded-lg text-xs font-semibold text-[#18181B] placeholder-[#A1A1AA] focus:outline-none focus:bg-[#FFFFFF] shadow-[inset_1px_1px_2px_rgba(0,0,0,0.06)]"
                    >
                </div>
            </div>
        @endif

        {{-- Daftar Opsi Pilihan (Scrollable jika data banyak) --}}
        <div class="max-h-60 overflow-y-auto space-y-1 pr-0.5" data-dropdown-options-list>
            @foreach ($options as $optValue => $optLabel)
                @php
                    $isCurrentlySelected = (string)$optValue === (string)$selectedValue;
                @endphp
                <button 
                    type="button" 
                    role="option" 
                    aria-selected="{{ $isCurrentlySelected ? 'true' : 'false' }}"
                    data-dropdown-item
                    data-value="{{ $optValue }}"
                    data-label="{{ $optLabel }}"
                    class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-xs font-bold transition-all text-left cursor-pointer {{ $isCurrentlySelected ? 'bg-[#18181B] text-[#FAF8F5]' : 'text-[#18181B] hover:bg-[#FAF8F5] hover:translate-x-0.5' }}"
                >
                    <div class="flex items-center gap-2 truncate">
                        @if ($optValue === 'Aktif' || $optValue === 'Lunas')
                            <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] border border-[#18181B] shrink-0"></span>
                        @elseif ($optValue === 'Suspend' || $optValue === 'Belum Bayar')
                            <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B] border border-[#18181B] shrink-0"></span>
                        @elseif ($optValue === 'Putus')
                            <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444] border border-[#18181B] shrink-0"></span>
                        @endif
                        <span class="truncate">{{ $optLabel }}</span>
                    </div>
                    
                    <i class="bi bi-check2 text-sm font-extrabold shrink-0 ml-2 {{ $isCurrentlySelected ? 'block text-[#FAF8F5]' : 'hidden' }}" data-dropdown-check></i>
                </button>
            @endforeach

            {{-- Pesan ketika hasil pencarian tidak ditemukan --}}
            <div data-dropdown-no-results class="hidden py-4 text-center text-xs font-bold text-[#71717A]">
                Tidak ada data yang cocok
            </div>
        </div>
    </div>
</div>
