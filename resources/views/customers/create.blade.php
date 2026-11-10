<x-app-layout>
    <x-slot:title>Tambah Pelanggan</x-slot:title>
    <x-slot:header>Tambah Pelanggan Baru</x-slot:header>

    <div class="max-w-2xl mx-auto">
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 sm:p-8 shadow-[6px_6px_0px_#18181B]">
            <div class="mb-6 pb-4 border-b-2 border-[#18181B] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold uppercase text-[#18181B]">Formulir Pelanggan Baru</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Lengkapi seluruh kolom data pelanggan di bawah ini</p>
                </div>
                <a 
                    href="{{ route('customers.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-[#18181B] bg-[#FFFFFF] text-xs font-bold text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    <i class="bi bi-arrow-left font-bold"></i> Kembali
                </a>
            </div>

            <form action="{{ route('customers.store') }}" method="POST" novalidate class="space-y-4">
                @csrf

                <!-- Nama Pelanggan -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Nama Pelanggan <span class="text-[#DC2626]">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('name') border-[#DC2626] bg-[#FEF2F2] @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label for="phone_number" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Nomor Telepon <span class="text-[#DC2626]">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="phone_number" 
                        id="phone_number" 
                        value="{{ old('phone_number') }}" 
                        required 
                        placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('phone_number') border-[#DC2626] bg-[#FEF2F2] @enderror"
                    >
                    @error('phone_number')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Pelanggan -->
                <div>
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Alamat Pemasangan <span class="text-[#DC2626]">*</span>
                    </label>
                    <textarea 
                        name="address" 
                        id="address" 
                        rows="3" 
                        required 
                        placeholder="Tuliskan alamat lengkap pelanggan..."
                        class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('address') border-[#DC2626] bg-[#FEF2F2] @enderror"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paket Internet & Harga Paket (Grid 2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="internet_package" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                            Paket Internet <span class="text-[#DC2626]">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="internet_package" 
                            id="internet_package" 
                            value="{{ old('internet_package') }}" 
                            required 
                            placeholder="Contoh: Home 50 Mbps"
                            class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('internet_package') border-[#DC2626] bg-[#FEF2F2] @enderror"
                        >
                        @error('internet_package')
                            <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="package_price" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                            Harga Paket (Rp) <span class="text-[#DC2626]">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="package_price" 
                            id="package_price" 
                            value="{{ old('package_price') }}" 
                            required 
                            min="0"
                            step="1000"
                            placeholder="Contoh: 350000"
                            class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('package_price') border-[#DC2626] bg-[#FEF2F2] @enderror"
                        >
                        @error('package_price')
                            <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status Pelanggan -->
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Status Pelanggan <span class="text-[#DC2626]">*</span>
                    </label>
                    <x-tactile-select 
                        name="status" 
                        id="status" 
                        :value="old('status', 'Aktif')" 
                        :options="['Aktif' => 'Aktif', 'Suspend' => 'Suspend', 'Putus' => 'Putus']" 
                        :hasError="$errors->has('status')" 
                    />
                    @error('status')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi Simpan & Batal -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t-2 border-[#E4E4E7]">
                    <a 
                        href="{{ route('customers.index') }}" 
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        <span>Simpan Pelanggan</span>
                        <i class="bi bi-check2 font-bold"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
