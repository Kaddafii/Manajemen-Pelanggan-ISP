<x-app-layout>
    <x-slot:title>Daftar Pelanggan</x-slot:title>
    <x-slot:header>Kelola Pelanggan</x-slot:header>

    <div class="space-y-5">
        <!-- Top Action Bar (Pencarian & Tombol Tambah) -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <!-- Form Pencarian Data -->
            <form action="{{ route('customers.index') }}" method="GET" class="flex items-center gap-2 flex-1 max-w-md">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif

                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#71717A]">
                        <i class="bi bi-search text-sm"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchKeyword }}" 
                        placeholder="Cari nama, telepon, atau paket..." 
                        class="w-full pl-9 pr-3 py-2 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[2px_2px_0px_#18181B] focus:outline-none focus:ring-0 placeholder-[#A1A1AA]"
                    >
                </div>

                <button 
                    type="submit" 
                    class="px-3.5 py-2 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    Cari
                </button>

                @if(!empty($searchKeyword))
                    <a 
                        href="{{ route('customers.index') }}" 
                        class="px-3 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                        title="Reset Pencarian"
                    >
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Tambah Pelanggan Baru -->
            <a 
                href="{{ route('customers.create') }}" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer shrink-0"
            >
                <i class="bi bi-plus-lg font-bold"></i>
                <span>Tambah Pelanggan</span>
            </a>
        </div>

        <!-- Tabel Data Pelanggan -->
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl shadow-[6px_6px_0px_#18181B] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#FAF8F5] border-b-2 border-[#18181B] text-[#18181B]">
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider w-12 text-center">No</th>
                            
                            {{-- Sorting Nama --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('customers.index', ['sort' => 'name', 'direction' => ($sortColumn === 'name' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Nama Pelanggan</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">Telepon & Alamat</th>

                            {{-- Sorting Paket --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('customers.index', ['sort' => 'internet_package', 'direction' => ($sortColumn === 'internet_package' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Paket Internet</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Harga --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('customers.index', ['sort' => 'package_price', 'direction' => ($sortColumn === 'package_price' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Harga Paket</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Status --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center">
                                <a href="{{ route('customers.index', ['sort' => 'status', 'direction' => ($sortColumn === 'status' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Status</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#18181B]">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-[#FAF8F5] transition-colors">
                                <td class="py-3 px-4 text-center font-bold text-[#71717A]">
                                    {{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}
                                </td>
                                <td class="py-3 px-4 font-bold text-[#18181B]">
                                    {{ $customer->name }}
                                </td>
                                <td class="py-3 px-4">
                                    <p class="font-semibold text-[#18181B]">{{ $customer->phone_number }}</p>
                                    <p class="text-[11px] text-[#71717A] truncate max-w-xs">{{ $customer->address }}</p>
                                </td>
                                <td class="py-3 px-4 font-medium text-[#18181B]">
                                    {{ $customer->internet_package }}
                                </td>
                                <td class="py-3 px-4 font-bold text-[#18181B]">
                                    Rp {{ number_format($customer->package_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if ($customer->status === 'Aktif')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#ECFDF5] text-[#047857]">
                                            Aktif
                                        </span>
                                    @elseif ($customer->status === 'Suspend')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#FFFBEB] text-[#B45309]">
                                            Suspend
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#FEF2F2] text-[#B91C1C]">
                                            Putus
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        <!-- Tombol Edit (Administrator & Staff) -->
                                        <a 
                                            href="{{ route('customers.edit', $customer) }}" 
                                            class="w-8 h-8 inline-flex items-center justify-center rounded-lg border-2 border-[#18181B] bg-[#FFFFFF] text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                                            title="Ubah Data Pelanggan"
                                        >
                                            <i class="bi bi-pencil-square text-xs"></i>
                                        </a>

                                        <!-- Tombol Hapus (Hanya Administrator Sesuai Spesifikasi) -->
                                        @if(auth()->user()->isAdministratorRole())
                                            <button 
                                                type="button" 
                                                data-delete-customer-id="{{ $customer->id }}"
                                                data-delete-customer-name="{{ $customer->name }}"
                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg border-2 border-[#DC2626] bg-[#FFFFFF] text-[#DC2626] shadow-[2px_2px_0px_#DC2626] hover:bg-[#FEF2F2] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#DC2626] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#DC2626] transition-all cursor-pointer"
                                                title="Hapus Data Pelanggan"
                                            >
                                                <i class="bi bi-trash3 text-xs"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-xl bg-[#FAF8F5] border-2 border-[#18181B] flex items-center justify-center text-[#71717A] mb-3 shadow-[2px_2px_0px_#18181B]">
                                            <i class="bi bi-people text-xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-[#18181B]">Belum Ada Data Pelanggan</p>
                                        <p class="text-xs text-[#71717A] mt-0.5">Silakan tambahkan data pelanggan baru melalui tombol di atas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Area Pagination Kustom Taktil -->
            @if ($customers->hasPages())
                <div class="p-4 border-t-2 border-[#18181B] bg-[#FAF8F5]">
                    {{ $customers->links('components.tactile-pagination') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Data (Khusus Administrator) -->
    @if(auth()->user()->isAdministratorRole())
        <div id="deleteModalBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity"></div>
        <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl max-w-sm w-full p-6 shadow-[6px_6px_0px_#18181B] text-center">
                <div class="w-12 h-12 rounded-xl bg-[#FEF2F2] border-2 border-[#DC2626] text-[#DC2626] flex items-center justify-center mx-auto mb-4 shadow-[2px_2px_0px_#DC2626]">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                </div>
                <h4 class="text-base font-extrabold uppercase text-[#18181B]">Hapus Pelanggan?</h4>
                <p class="text-xs text-[#71717A] mt-1.5 leading-relaxed">
                    Data pelanggan <strong id="deleteCustomerName" class="text-[#18181B]"></strong> akan dihapus menggunakan mekanisme Soft Delete.
                </p>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <button 
                        type="button" 
                        id="cancelDeleteButton" 
                        class="flex-1 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Batal
                    </button>

                    <form id="deleteCustomerForm" method="POST" action="" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="w-full py-2 rounded-xl bg-[#DC2626] text-[#FFFFFF] font-bold text-xs uppercase tracking-wider border-2 border-[#DC2626] shadow-[2px_2px_0px_#18181B] hover:bg-[#B91C1C] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                        >
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
