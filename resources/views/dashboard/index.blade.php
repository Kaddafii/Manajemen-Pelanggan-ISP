<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Manajemen Pelanggan ISP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF8F5] text-[#18181B] font-sans antialiased min-h-screen">
    <header class="w-full py-4 px-6 border-b-2 border-[#18181B] bg-[#FFFFFF] flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-[#18181B] text-[#FAF8F5] flex items-center justify-center border-2 border-[#18181B] shadow-[2px_2px_0px_#18181B]">
                <i class="bi bi-router text-lg"></i>
            </div>
            <div>
                <h1 class="text-base font-bold uppercase leading-none">Manajemen Pelanggan ISP</h1>
                <p class="text-xs text-[#71717A] mt-0.5">Role: {{ auth()->user()->role ?? 'Guest' }} ({{ auth()->user()->name ?? '-' }})</p>
            </div>
        </div>

        <form action="{{ route('logout.terminate') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-[#FFFFFF] text-[#DC2626] border-2 border-[#DC2626] font-bold text-xs uppercase shadow-[2px_2px_0px_#DC2626] hover:bg-[#FEF2F2] transition-all cursor-pointer">
                <i class="bi bi-box-arrow-right"></i>
                Keluar
            </button>
        </form>
    </header>

    <main class="max-w-7xl mx-auto py-10 px-6">
        <div class="bg-[#FFFFFF] border-2 border-[#18181B] rounded-2xl p-6 shadow-[6px_6px_0px_#18181B]">
            <h2 class="text-xl font-bold uppercase mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-sm text-[#71717A]">
                Login berhasil sebagai <strong>{{ auth()->user()->role }}</strong>. Modul Dashboard dan modul lainnya akan dibangun pada langkah berikutnya sesuai dengan <code class="font-mono bg-[#F4F4F5] px-1 py-0.5 rounded border border-[#18181B]">RULES_AND_SPECIFICATION.md</code>.
            </p>
        </div>
    </main>
</body>
</html>
