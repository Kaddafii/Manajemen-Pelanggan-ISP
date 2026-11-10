<x-app-layout>
    <x-slot:title>Tambah Pengguna</x-slot:title>
    <x-slot:header>Tambah Pengguna Baru</x-slot:header>

    <div class="max-w-2xl mx-auto">
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 sm:p-8 shadow-[6px_6px_0px_#18181B]">
            <div class="mb-6 pb-4 border-b-2 border-[#18181B] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-extrabold uppercase text-[#18181B]">Formulir Pengguna Baru</h3>
                    <p class="text-xs text-[#71717A] mt-0.5">Lengkapi data akun untuk Administrator atau Staff</p>
                </div>
                <a 
                    href="{{ route('users.index') }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border-2 border-[#18181B] bg-[#FFFFFF] text-xs font-bold text-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                >
                    <i class="bi bi-arrow-left font-bold"></i> Kembali
                </a>
            </div>

            <form action="{{ route('users.store') }}" method="POST" novalidate class="space-y-4">
                @csrf

                <!-- Nama Pengguna -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Nama Pengguna <span class="text-[#DC2626]">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}" 
                        required 
                        placeholder="Contoh: Muhammad Rizky"
                        class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('name') border-[#DC2626] bg-[#FEF2F2] @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Alamat Email <span class="text-[#DC2626]">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="nama@isp.com"
                        class="w-full px-3.5 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('email') border-[#DC2626] bg-[#FEF2F2] @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Password <span class="text-[#DC2626]">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-3.5 pr-10 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-xl text-xs text-[#18181B] shadow-[inset_1px_2px_3px_rgba(0,0,0,0.06)] focus:outline-none focus:ring-0 placeholder-[#A1A1AA] @error('password') border-[#DC2626] bg-[#FEF2F2] @enderror"
                        >
                        <button 
                            type="button" 
                            data-toggle-password="password"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#71717A] hover:text-[#18181B] cursor-pointer"
                            aria-label="Tampilkan atau sembunyikan password"
                        >
                            <i class="bi bi-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Pengguna -->
                <div>
                    <label for="role" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Role Pengguna <span class="text-[#DC2626]">*</span>
                    </label>

                    <x-tactile-select 
                        name="role" 
                        id="role" 
                        :value="old('role', 'Staff')" 
                        :options="['Administrator' => 'Administrator', 'Staff' => 'Staff']" 
                        :hasError="$errors->has('role')" 
                    />

                    @error('role')
                        <p class="mt-1 text-xs font-bold text-[#DC2626]">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi Simpan & Batal -->
                <div class="pt-4 flex items-center justify-end gap-3 border-t-2 border-[#E4E4E7]">
                    <a 
                        href="{{ route('users.index') }}" 
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-[#FFFFFF] text-[#18181B] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] hover:bg-[#F4F4F5] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[3px_3px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-xs uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer"
                    >
                        <span>Simpan Pengguna</span>
                        <i class="bi bi-check2 font-bold"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
