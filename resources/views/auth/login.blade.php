<x-guest-layout>
    <x-slot:title>Masuk ke Akun</x-slot:title>

    <div class="w-full max-w-md">
        <!-- Kartu Formulir Login -->
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 sm:p-8 shadow-[6px_6px_0px_#18181B]">

            <!-- Judul Form -->
            <div class="mb-6 text-center">
                <div
                    class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-[#FAF8F5] border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B] mb-3 text-[#18181B]">
                    <i class="bi bi-shield-lock text-2xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold tracking-tight text-[#18181B] uppercase">Masuk Akun</h2>
            </div>

            <!-- Alert Banner Kesalahan -->
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl border-2 border-[#DC2626] bg-[#FEF2F2] shadow-[3px_3px_0px_#DC2626]">
                <div class="flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-lg text-[#DC2626] mt-0.5"></i>
                    <div class="flex-1">
                        <h3 class="text-xs font-bold uppercase tracking-wide text-[#991B1B]">Gagal Masuk</h3>
                        <p class="text-xs text-[#B91C1C] mt-0.5 font-medium">
                            {{ $errors->first() }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Formulir Login -->
            <form action="{{ route('login.authenticate') }}" method="POST" novalidate class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Email <span class="text-[#DC2626]">*</span>
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#71717A]">
                            <i class="bi bi-envelope text-base"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-lg text-sm text-[#18181B] placeholder-[#A1A1AA] shadow-[inset_1px_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#18181B] focus:ring-2 focus:ring-[#E4E4E7] transition-all @error('email') border-[#DC2626] bg-[#FEF2F2] @enderror">
                    </div>
                    @error('email')
                    <p class="mt-1.5 text-xs font-semibold text-[#DC2626] flex items-center gap-1">
                        <i class="bi bi-x-circle-fill text-xs"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Input Kata Sandi -->
                <div>
                    <label for="password"
                        class="block text-xs font-bold uppercase tracking-wider text-[#18181B] mb-1.5">
                        Password <span class="text-[#DC2626]">*</span>
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#71717A]">
                            <i class="bi bi-key text-base"></i>
                        </div>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-11 py-2.5 bg-[#FFFFFF] border-2 border-[#18181B] rounded-lg text-sm text-[#18181B] placeholder-[#A1A1AA] shadow-[inset_1px_2px_4px_rgba(0,0,0,0.06)] focus:outline-none focus:border-[#18181B] focus:ring-2 focus:ring-[#E4E4E7] transition-all @error('password') border-[#DC2626] bg-[#FEF2F2] @enderror">
                        <!-- Tombol Show/Hide Password -->
                        <button type="button" id="togglePasswordButton" aria-label="Tampilkan atau sembunyikan password"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#71717A] hover:text-[#18181B] focus:outline-none">
                            <i class="bi bi-eye text-base" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1.5 text-xs font-semibold text-[#DC2626] flex items-center gap-1">
                        <i class="bi bi-x-circle-fill text-xs"></i>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <!-- Checkbox Ingat Saya -->
                <div class="flex items-center pt-1">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked'
                            : '' }}
                            class="w-4 h-4 rounded border-2 border-[#18181B] text-[#18181B] focus:ring-0 focus:outline-none cursor-pointer accent-[#18181B]">
                        <span class="text-xs font-semibold text-[#52525B]">Ingat saya</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-[#18181B] text-[#FAF8F5] font-bold text-sm uppercase tracking-wider border-2 border-[#18181B] shadow-[3px_3px_0px_#18181B] hover:bg-[#27272A] hover:-translate-x-0.5 hover:-translate-y-0.5 hover:shadow-[4px_4px_0px_#18181B] active:translate-x-0.5 active:translate-y-0.5 active:shadow-[1px_1px_0px_#18181B] transition-all cursor-pointer">
                        <span>Masuk</span>
                        <i class="bi bi-box-arrow-in-right text-base font-bold"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>