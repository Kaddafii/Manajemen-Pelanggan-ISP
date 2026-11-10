<x-app-layout>
    <x-slot:title>Tambah Tagihan</x-slot:title>
    <x-slot:header>Tambah Tagihan Baru</x-slot:header>

    <div class="max-w-2xl mx-auto">
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 sm:p-8 shadow-[6px_6px_0px_#18181B]" id="invoiceFormContainer" data-customer-prices='@json($customers->pluck("package_price", "id"))'>
            <div class="mb-6 pb-4 border-b-2 border-[#18181B] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold uppercase text-[#18181B]">Formulir Tagihan Baru</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Pilih pelanggan dan tentukan periode serta nominal tagihan</p>
                </div>
                <a 
                    href="{{ route('invoices.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-[#18181B] bg-[#FFFFFF] text-xs font-bold text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    <i class="bi bi-arrow-left font-bold"></i> Kembali
                </a>
            </div>

            <form action="{{ route('invoices.store') }}" method="POST" novalidate class="space-y-4">
                @csrf

                <!-- Pilih Pelanggan -->
                <div>
                    <label for="customer_id" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Pelanggan <span class="text-[#DC2626]">*</span>
                    </label>

                    @php
                        $customerOptions = [];
                        foreach ($customers as $cust) {
                            $customerOptions[$cust->id] = $cust->name . ' (' . $cust->internet_package . ' - Rp ' . number_format($cust->package_price, 0, ',', '.') . ')';
                        }
                    @endphp

                    <x-tactile-select 
                        name="customer_id" 
                        id="customer_id" 
                        :value="old('customer_id', $selectedCustomerId ?? '')" 
                        :options="$customerOptions" 
                        placeholder="-- Pilih Pelanggan --"
                        :searchable="true"
                        searchPlaceholder="Cari nama atau paket pelanggan..."
                        :hasError="$errors->has('customer_id')" 
                    />

                    @error('customer_id')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Periode Tagihan & Nominal Tagihan (Grid 2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="billing_period" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                            Periode Tagihan <span class="text-[#DC2626]">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="billing_period" 
                            id="billing_period" 
                            value="{{ old('billing_period', now()->translatedFormat('F Y')) }}" 
                            required 
                            placeholder="Contoh: Maret 2026"
                            class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('billing_period') border-[#DC2626] bg-[#FEF2F2] @enderror"
                        >
                        @error('billing_period')
                            <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="billing_amount" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                            Nominal Tagihan (Rp) <span class="text-[#DC2626]">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="billing_amount" 
                            id="billing_amount" 
                            value="{{ old('billing_amount') }}" 
                            required 
                            min="0"
                            step="1000"
                            placeholder="Contoh: 350000"
                            class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('billing_amount') border-[#DC2626] bg-[#FEF2F2] @enderror"
                        >
                        @error('billing_amount')
                            <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Pembayaran Awal -->
                <div>
                    <label for="payment_status" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Status Pembayaran <span class="text-[#DC2626]">*</span>
                    </label>

                    <x-tactile-select 
                        name="payment_status" 
                        id="payment_status" 
                        :value="old('payment_status', 'Belum Bayar')" 
                        :options="['Belum Bayar' => 'Belum Bayar', 'Lunas' => 'Lunas']" 
                        :hasError="$errors->has('payment_status')" 
                    />

                    @error('payment_status')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi Simpan & Batal -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t-2 border-[#E4E4E7]">
                    <a 
                        href="{{ route('invoices.index') }}" 
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        <span>Simpan Tagihan</span>
                        <i class="bi bi-check2 font-bold"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
