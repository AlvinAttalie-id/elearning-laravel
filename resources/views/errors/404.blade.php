<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4 py-16 bg-white">
        <div class="grid items-center w-full max-w-6xl grid-cols-1 gap-10 md:grid-cols-2">

            {{-- Gambar Kiri --}}
            <div>
                <img src="{{ asset('images/404.svg') }}" alt="404 Illustration" class="w-full max-w-md mx-auto" />
            </div>

            {{-- Teks Kanan --}}
            <div class="text-center md:text-left">
                <h1 class="mb-4 text-6xl font-extrabold text-gray-900">Oops!</h1>
                <h2 class="mb-2 text-2xl font-semibold text-gray-700">404 - Halaman Tidak Ditemukan</h2>
                <p class="mb-6 text-gray-500">
                    Halaman yang kamu cari mungkin telah dipindahkan, dihapus, atau tidak tersedia untuk sementara.
                </p>

                {{-- Tombol --}}
                <a href="{{ route('dashboard') }}"
                    class="inline-block px-6 py-3 font-medium text-indigo-600 transition border border-indigo-600 rounded-full hover:bg-indigo-600 hover:text-white">
                    Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>
</x-guest-layout>
