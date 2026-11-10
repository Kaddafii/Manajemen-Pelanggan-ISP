<x-app-layout>
    <x-slot:title>Daftar Tagihan</x-slot:title>
    <x-slot:header>Kelola Tagihan</x-slot:header>

    <div class="space-y-5">
        <!-- Top Action Bar (Pencarian, Filter Status & Tombol Tambah) -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <!-- Form Pencarian & Filter Status -->
            <form action="{{ route('invoices.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1 max-w-xl">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif

                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#71717A]">
                        <i class="bi bi-search text-sm"></i>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $searchKeyword }}" 
                        placeholder="Cari pelanggan atau periode..." 
                        class="w-full pl-9 pr-3 py-2 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[2px_2px_0px_#18181B] focus:outline-none focus:ring-0 placeholder-[#A1A1AA]"
                    >
                </div>

                <!-- Filter Status Pembayaran Menggunakan Custom Dropdown Taktil -->
                <div class="w-40 sm:w-44">
                    <x-tactile-select 
                        name="status" 
                        id="payment_status_filter" 
                        :value="$paymentStatusFilter ?? ''" 
                        :options="['' => 'Semua Status', 'Belum Bayar' => 'Belum Bayar', 'Lunas' => 'Lunas']" 
                        placeholder="Semua Status"
                        :autoSubmitForm="true"
                    />
                </div>

                <button 
                    type="submit" 
                    class="px-3.5 py-2 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    Cari
                </button>

                @if(!empty($searchKeyword) || !empty($paymentStatusFilter))
                    <a 
                        href="{{ route('invoices.index') }}" 
                        class="px-3 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                        title="Reset Filter"
                    >
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </form>

            <!-- Tombol Tambah Tagihan Baru (Khusus Administrator) -->
            @if(auth()->user()->isAdministratorRole())
                <a 
                    href="{{ route('invoices.create') }}" 
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer shrink-0"
                >
                    <i class="bi bi-plus-lg font-bold"></i>
                    <span>Tambah Tagihan</span>
                </a>
            @endif
        </div>

        <!-- Tabel Data Tagihan -->
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl shadow-[6px_6px_0px_#18181B] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#FAF8F5] border-b-2 border-[#18181B] text-[#18181B]">
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider w-12 text-center">No</th>
                            
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">Pelanggan</th>

                            {{-- Sorting Periode --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('invoices.index', ['sort' => 'billing_period', 'direction' => ($sortColumn === 'billing_period' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'status' => $paymentStatusFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Periode Tagihan</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Nominal --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider">
                                <a href="{{ route('invoices.index', ['sort' => 'billing_amount', 'direction' => ($sortColumn === 'billing_amount' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'status' => $paymentStatusFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Nominal Tagihan</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Sorting Status Pembayaran --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center">
                                <a href="{{ route('invoices.index', ['sort' => 'payment_status', 'direction' => ($sortColumn === 'payment_status' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'status' => $paymentStatusFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Status</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            {{-- Tanggal Pembayaran --}}
                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center">
                                <a href="{{ route('invoices.index', ['sort' => 'payment_date', 'direction' => ($sortColumn === 'payment_date' && $sortDirection === 'asc') ? 'desc' : 'asc', 'search' => $searchKeyword, 'status' => $paymentStatusFilter]) }}" class="inline-flex items-center gap-1.5 hover:underline">
                                    <span>Tanggal Pembayaran</span>
                                    <i class="bi bi-arrow-down-up text-[10px]"></i>
                                </a>
                            </th>

                            <th class="py-3 px-4 font-extrabold uppercase tracking-wider text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-[#18181B]">
                        @forelse ($invoices as $invoice)
                            <tr class="hover:bg-[#FAF8F5] transition-colors">
                                <td class="py-3 px-4 text-center font-bold text-[#71717A]">
                                    {{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}
                                </td>
                                <td class="py-3 px-4">
                                    <p class="font-bold text-[#18181B]">{{ $invoice->customer->name ?? 'Pelanggan Tidak Ditemukan' }}</p>
                                    <p class="text-[11px] text-[#71717A]">{{ $invoice->customer->phone_number ?? '-' }}</p>
                                </td>
                                <td class="py-3 px-4 font-semibold text-[#18181B]">
                                    {{ $invoice->billing_period }}
                                </td>
                                <td class="py-3 px-4 font-bold text-[#18181B]">
                                    Rp {{ number_format($invoice->billing_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if ($invoice->isPaidStatus())
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#ECFDF5] text-[#047857]">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-[#18181B] bg-[#FFFBEB] text-[#B45309]">
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center text-[11px] whitespace-nowrap">
                                    @if ($invoice->payment_date)
                                        <span class="font-bold text-[#18181B]">{{ $invoice->payment_date->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB' }}</span>
                                    @else
                                        <span class="font-medium text-[#71717A]">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if ($invoice->isUnpaidStatus())
                                        @if(auth()->user()->isAdministratorRole())
                                            <!-- Tombol Bayar (Khusus Administrator Sesuai Spesifikasi) -->
                                            <button 
                                                type="button" 
                                                data-pay-invoice-id="{{ $invoice->id }}"
                                                data-pay-invoice-customer="{{ $invoice->customer->name ?? '-' }}"
                                                data-pay-invoice-period="{{ $invoice->billing_period }}"
                                                data-pay-invoice-amount="Rp {{ number_format($invoice->billing_amount, 0, ',', '.') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border-2 border-[#18181B] bg-[#10B981] text-[#FFFFFF] font-bold text-xs shadow-[2px_2px_0px_#18181B] hover:bg-[#059669] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                                                title="Bayar Tagihan"
                                            >
                                                <i class="bi bi-cash-stack font-bold"></i>
                                                <span>Bayar</span>
                                            </button>
                                        @else
                                            <span class="text-[11px] font-bold text-[#71717A]">-</span>
                                        @endif
                                    @else
                                        <div class="inline-flex items-center gap-1 text-[11px] font-bold text-[#047857]">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Selesai</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-xl bg-[#FAF8F5] border-2 border-[#18181B] flex items-center justify-center text-[#71717A] mb-3 shadow-[2px_2px_0px_#18181B]">
                                            <i class="bi bi-receipt text-xl"></i>
                                        </div>
                                        <p class="text-sm font-bold text-[#18181B]">Belum Ada Data Tagihan</p>
                                        <p class="text-xs text-[#71717A] mt-0.5">
                                            @if(auth()->user()->isAdministratorRole())
                                                Silakan buat tagihan baru melalui tombol di atas.
                                            @else
                                                Belum ada tagihan yang dicatat oleh Administrator.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Area Pagination Kustom Taktil -->
            @if ($invoices->hasPages())
                <div class="p-4 border-t-2 border-[#18181B] bg-[#FAF8F5]">
                    {{ $invoices->links('components.tactile-pagination') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Konfirmasi Pembayaran Tagihan (Khusus Administrator) -->
    @if(auth()->user()->isAdministratorRole())
        <div id="paymentModalBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden transition-opacity"></div>
        <div id="paymentConfirmationModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl max-w-sm w-full p-6 shadow-[6px_6px_0px_#18181B] text-center">
                <div class="w-12 h-12 rounded-xl bg-[#ECFDF5] border-2 border-[#10B981] text-[#047857] flex items-center justify-center mx-auto mb-4 shadow-[2px_2px_0px_#10B981]">
                    <i class="bi bi-cash-coin text-2xl"></i>
                </div>
                <h4 class="text-base font-extrabold uppercase text-[#18181B]">Konfirmasi Pembayaran</h4>
                <p class="text-xs text-[#71717A] mt-1.5 leading-relaxed">
                    Tandai tagihan periode <strong id="payInvoicePeriod" class="text-[#18181B]"></strong> untuk pelanggan <strong id="payInvoiceCustomer" class="text-[#18181B]"></strong> sebesar <strong id="payInvoiceAmount" class="text-[#047857]"></strong> sebagai <strong>Lunas</strong>?
                </p>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <button 
                        type="button" 
                        id="cancelPaymentButton" 
                        class="flex-1 py-2 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Batal
                    </button>

                    <form id="payInvoiceForm" method="POST" action="" class="flex-1">
                        @csrf
                        @method('PATCH')
                        <button 
                            type="submit" 
                            class="w-full py-2 rounded-xl bg-[#10B981] text-[#FFFFFF] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#059669] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                        >
                            Bayar Lunas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
