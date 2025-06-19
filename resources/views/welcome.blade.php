<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E‑Learning Sekolah</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Styles (Tailwind + custom) & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine JS (untuk menu mobile) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <!-- NAVBAR -->
    <nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white border-b shadow-sm">
        <div class="flex items-center justify-between h-16 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center gap-2">
                <i class="text-xl text-indigo-600 fa-solid fa-graduation-cap"></i>
                <span class="text-xl font-bold">E‑Learning</span>
            </div>

            <!-- Desktop links -->
            <div class="items-center hidden gap-8 font-medium md:flex">
                <a href="#fitur" class="hover:text-indigo-600">Fitur</a>
                <a href="#kelas" class="hover:text-indigo-600">Kelas</a>
                <a href="#kontak" class="hover:text-indigo-600">Kontak</a>
            </div>

            <!-- Auth buttons -->
            <div class="items-center hidden gap-4 md:flex">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded hover:bg-gray-100">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-white transition bg-indigo-600 rounded hover:bg-indigo-700">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Burger -->
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <i class="text-xl fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile menu -->
        <div x-show="open" x-collapse class="px-4 pt-2 pb-4 space-y-2 md:hidden">
            <a href="#fitur" class="block px-3 py-2 rounded hover:bg-gray-100">Fitur</a>
            <a href="#kelas" class="block px-3 py-2 rounded hover:bg-gray-100">Kelas</a>
            <a href="#kontak" class="block px-3 py-2 rounded hover:bg-gray-100">Kontak</a>

            @if (Route::has('login'))
                <div class="pt-2 border-t">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="block px-3 py-2 mt-1 text-white bg-indigo-600 rounded hover:bg-indigo-700">Daftar</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!--  HERO  -->
    <section class="relative text-white bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="px-4 py-20 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
            <h1 class="mb-4 text-4xl font-extrabold leading-tight sm:text-5xl">
                Belajar Lebih Mudah &amp; Menyenangkan
            </h1>
            <p class="mb-8 text-lg sm:text-xl">
                Platform E‑Learning interaktif untuk meningkatkan kualitas pembelajaran di sekolah Anda.
            </p>
            <a href="{{ route('register') }}"
                class="inline-block px-8 py-3 font-semibold text-indigo-600 transition bg-white rounded-full shadow-lg hover:bg-gray-100">
                Mulai Sekarang
            </a>
        </div>
        <svg class="absolute bottom-0 w-full h-12 text-white" viewBox="0 0 1440 100" preserveAspectRatio="none">
            <path d="M0,0 C60,100 180,100 360,50 C540,0 720,0 900,50 C1080,100 1260,100 1440,50 L1440,100 L0,100 Z"
                fill="currentColor"></path>
        </svg>
    </section>

    <!--  FEATURES  -->
    <section id="fitur" class="py-16 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-12 text-3xl font-bold text-center">Kenapa Memilih Kami?</h2>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="p-8 transition bg-white shadow rounded-2xl hover:shadow-lg" data-aos="fade-up">
                    <i data-lucide="play-circle" class="w-12 h-12 mb-4 text-indigo-600"></i>
                    <h3 class="mb-2 text-xl font-semibold">Konten Interaktif</h3>
                    <p class="text-gray-600">Video, kuis, dan forum diskusi membuat proses belajar lebih seru.</p>
                </div>
                <div class="p-8 transition bg-white shadow rounded-2xl hover:shadow-lg" data-aos="fade-up"
                    data-aos-delay="100">
                    <i data-lucide="users" class="w-12 h-12 mb-4 text-indigo-600"></i>
                    <h3 class="mb-2 text-xl font-semibold">Guru Profesional</h3>
                    <p class="text-gray-600">Dipandu tenaga pendidik bersertifikat dan berpengalaman.</p>
                </div>
                <div class="p-8 transition bg-white shadow rounded-2xl hover:shadow-lg" data-aos="fade-up"
                    data-aos-delay="200">
                    <i data-lucide="bar-chart-3" class="w-12 h-12 mb-4 text-indigo-600"></i>
                    <h3 class="mb-2 text-xl font-semibold">Laporan Progres</h3>
                    <p class="text-gray-600">Pantau perkembangan belajar siswa melalui dashboard analitik.</p>
                </div>
            </div>
        </div>
    </section>

    <!--  STATISTICS  -->
    <section class="py-16">
        <div class="grid gap-8 px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8 md:grid-cols-3">
            <div>
                <p class="text-4xl font-extrabold text-indigo-600">120+</p>
                <p class="mt-2 text-gray-600">Kelas Aktif</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-indigo-600">30</p>
                <p class="mt-2 text-gray-600">Guru Tersertifikasi</p>
            </div>
            <div>
                <p class="text-4xl font-extrabold text-indigo-600">2K+</p>
                <p class="mt-2 text-gray-600">Siswa Terdaftar</p>
            </div>
        </div>
    </section>

    <!--  CTA  -->
    <section class="text-white bg-indigo-600">
        <div class="px-4 py-16 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
            <h2 class="mb-4 text-3xl font-bold">Siap Memulai?</h2>
            <p class="mb-8 text-lg">Daftarkan akun Anda sekarang dan rasakan pengalaman belajar digital terbaik.</p>
            <a href="{{ route('register') }}"
                class="px-8 py-3 font-semibold text-indigo-600 transition bg-white rounded-full shadow-lg hover:bg-gray-100">
                Daftar Gratis
            </a>
        </div>
    </section>

    <!--  FOOTER  -->
    <footer id="kontak" class="text-gray-300 bg-gray-800">
        <div class="grid gap-8 px-4 py-10 mx-auto max-w-7xl sm:px-6 lg:px-8 md:grid-cols-2">
            <div>
                <h3 class="mb-3 text-xl font-bold text-white">E‑Learning Sekolah</h3>
                <p class="text-sm leading-relaxed">
                    Jl. Pendidikan No. 123, Kota ABC<br>
                    Telp: (021) 123‑4567<br>
                    Email: info@elearning‑sekolah.id
                </p>
            </div>
            <div class="flex items-start gap-6 md:justify-end">
                <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-youtube"></i></a>
                <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="py-4 text-sm text-center border-t border-gray-700">
            © {{ date('Y') }} E‑Learning Sekolah • All rights reserved
        </div>
    </footer>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons()
    </script>

    <!-- (Opsional) AOS Animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true, // opsional, supaya animasi hanya terjadi sekali
            });
        });
    </script>

</body>

</html>
