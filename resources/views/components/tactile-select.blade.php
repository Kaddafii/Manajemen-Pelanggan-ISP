@props([
    'name',
    'id' => null,
    'value' => '',
    'options' => [],
    'placeholder' => 'Pilih pilihan...',
    'hasError' => false,
])

@php
    $inputId = $id ?? $name;
    $selectedValue = (string) $value;
    $selectedLabel = $options[$selectedValue] ?? $selectedValue;
    if (empty($selectedLabel) && !empty($options)) {
        $selectedLabel = $placeholder;
    }
@endphp

<div class="relative" data-dropdown-container>
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
            @if ($selectedValue === 'Aktif')
                <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] border border-[#18181B] shrink-0" data-dropdown-trigger-dot></span>
            @elseif ($selectedValue === 'Suspend')
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
        <i class="bi bi-chevron-down text-xs font-bold text-[#18181B] transition-transform duration-200 shrink-0" data-dropdown-arrow></i>
    </button>

    {{-- Menu opsi melayang taktil --}}
    <div 
        id="{{ $inputId }}-options" 
        role="listbox" 
        tabindex="-1"
        data-dropdown-menu
        class="hidden absolute left-0 right-0 top-full mt-1.5 z-50 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl shadow-[4px_4px_0px_#18181B] p-1.5 space-y-1"
    >
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
                <div class="flex items-center gap-2">
                    @if ($optValue === 'Aktif')
                        <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] border border-[#18181B] shrink-0"></span>
                    @elseif ($optValue === 'Suspend')
                        <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B] border border-[#18181B] shrink-0"></span>
                    @elseif ($optValue === 'Putus')
                        <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444] border border-[#18181B] shrink-0"></span>
                    @endif
                    <span>{{ $optLabel }}</span>
                </div>
                
                <i class="bi bi-check2 text-sm font-extrabold {{ $isCurrentlySelected ? 'block text-[#FAF8F5]' : 'hidden' }}" data-dropdown-check></i>
            </button>
        @endforeach
    </div>
</div>
