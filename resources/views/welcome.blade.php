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
    <link rel="icon" href="{{ asset('logo-cusomize.png') }}">

    <!-- Styles (Tailwind + custom) & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine JS (untuk menu mobile) -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .backface-hidden {
            backface-visibility: hidden;
        }
    </style>

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
            <h2 class="mb-8 text-3xl font-bold text-center">Kenapa Memilih Kami?</h2>
            <div class="grid justify-center grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @php
                    $cards = [
                        [
                            'img' => 'card1.svg',
                            'title' => 'Konten Interaktif',
                            'desc' => 'Video, kuis, dan forum diskusi membuat proses belajar lebih seru.',
                            'back' => 'Kami percaya belajar itu harus seru dan interaktif agar mudah dipahami siswa.',
                        ],
                        [
                            'img' => 'card2.svg',
                            'title' => 'Guru Profesional',
                            'desc' => 'Dipandu tenaga pendidik bersertifikat dan berpengalaman.',
                            'back' => 'Guru kami tidak hanya ahli di bidangnya, tapi juga komunikatif & inspiratif.',
                        ],
                        [
                            'img' => 'card3.svg',
                            'title' => 'Laporan Progres',
                            'desc' => 'Pantau perkembangan belajar siswa melalui dashboard analitik.',
                            'back' => 'Pantauan belajar siswa yang bisa diakses guru dan orang tua secara real-time.',
                        ],
                    ];
                @endphp

                @foreach ($cards as $card)
                    <div class="group [perspective:1000px] w-full h-[340px]">
                        <div
                            class="relative w-full h-full duration-700 [transform-style:preserve-3d] group-hover:[transform:rotateY(180deg)]">
                            <!-- Front -->
                            <div class="absolute inset-0 bg-white shadow-md rounded-2xl backface-hidden">
                                <div class="flex flex-col h-full gap-3 p-4">
                                    <img src="{{ asset('images/' . $card['img']) }}" alt="fitur"
                                        class="object-contain w-full mb-2 h-36 rounded-xl">
                                    <div>
                                        <h3 class="mb-1 text-xl font-semibold text-indigo-600">{{ $card['title'] }}
                                        </h3>
                                        <p class="leading-snug text-gray-600 text-m">{{ $card['desc'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Back -->
                            <div
                                class="absolute inset-0 bg-indigo-600 text-white rounded-2xl p-6 [transform:rotateY(180deg)] backface-hidden flex flex-col items-center justify-center text-center">
                                <h3 class="mb-2 text-lg font-bold">{{ $card['title'] }}</h3>
                                <p class="leading-relaxed text-m">{{ $card['back'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!--  STATISTICS  -->
    <section class="py-16">
        <div class="grid grid-cols-1 gap-10 px-6 mx-auto text-center max-w-7xl sm:grid-cols-3">
            <div
                class="flex flex-col items-center justify-center transition duration-300 transform hover:-translate-y-1 hover:scale-105">
                <i data-lucide="book-open" class="w-10 h-10 mb-2 text-indigo-600"></i>
                <p class="text-5xl font-extrabold text-indigo-600">120+</p>
                <p class="mt-1 text-lg font-medium text-gray-700">Kelas Aktif</p>
            </div>
            <div
                class="flex flex-col items-center justify-center transition duration-300 transform hover:-translate-y-1 hover:scale-105">
                <i data-lucide="user-check" class="w-10 h-10 mb-2 text-indigo-600"></i>
                <p class="text-5xl font-extrabold text-indigo-600">30</p>
                <p class="mt-1 text-lg font-medium text-gray-700">Guru Tersertifikasi</p>
            </div>
            <div
                class="flex flex-col items-center justify-center transition duration-300 transform hover:-translate-y-1 hover:scale-105">
                <i data-lucide="users" class="w-10 h-10 mb-2 text-indigo-600"></i>
                <p class="text-5xl font-extrabold text-indigo-600">2K+</p>
                <p class="mt-1 text-lg font-medium text-gray-700">Siswa Terdaftar</p>
            </div>
        </div>
    </section>


    <!--  Happy Customer  -->
    <section id="Happy-Customer" class="relative py-16 bg-white">
        <div class="flex flex-col gap-5 px-8 text-center md:px-16">
            <h2 class="text-xl font-bold text-blue-600">Happy User</h2>
            <p class="text-3xl font-bold leading-tight md:text-4xl">Happy User Feedback on Our Services</p>
        </div>

        <div id="Card-Slider" class="relative flex flex-col gap-2 mt-[30px] overflow-hidden">
            <div id="Top-Slider" class="flex flex-row group flex-nowrap">
                <div class="flex flex-row gap-6 pl-6 w-max flex-nowrap animate-slide-right">
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-1.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Nabila Reyna</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Patungan akun di sini terpercaya, gak nyesel!
                                Netflix dan Disney+ lancar jaya, harga terjangkau pula!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-2.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bapak Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Hemat banget patungan akun di sini! Nonton Netflix
                                dan Spotify jadi lebih terjangkau. Proses cepat dan tanpa ribet!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-3.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Ibu Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">“Layanan patungan akun terbaik! Bisa langganan
                                Netflix dan Disney+ jadi lebih murah. Proses mudah dan aman, rekomendasi banget!”</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-4.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Murayiki Bazz</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Website ini bikin langganan lebih ringan di
                                kantong. Langsung bisa akses Disney+, Netflix, dan lainnya. Top deh!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-5.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bimore Atreidess</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Layanan top! Dulu nonton Netflix mahal, sekarang
                                lebih hemat dengan patungan akun. Proses gampang dan cepat!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-6.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Unil Utami</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Bisa nikmatin Spotify dan Disney+ murah banget!
                                Patungan di sini bikin semua jadi mudah dan terpercaya."</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-7.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Allison Suzu</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Solusi buat yang mau langganan akun premium murah.
                                Proses cepat dan aman, Netflix dan Disney+ lancar!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-6 pl-6 w-max flex-nowrap animate-slide-right">
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-1.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Nabila Reyna</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Patungan akun di sini terpercaya, gak nyesel!
                                Netflix dan Disney+ lancar jaya, harga terjangkau pula!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-2.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bapak Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Hemat banget patungan akun di sini! Nonton Netflix
                                dan Spotify jadi lebih terjangkau. Proses cepat dan tanpa ribet!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-3.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Ibu Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">“Layanan patungan akun terbaik! Bisa langganan
                                Netflix dan Disney+ jadi lebih murah. Proses mudah dan aman, rekomendasi banget!”</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-4.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Murayiki Bazz</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Website ini bikin langganan lebih ringan di
                                kantong. Langsung bisa akses Disney+, Netflix, dan lainnya. Top deh!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-5.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bimore Atreidess</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Layanan top! Dulu nonton Netflix mahal, sekarang
                                lebih hemat dengan patungan akun. Proses gampang dan cepat!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-6.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Unil Utami</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Bisa nikmatin Spotify dan Disney+ murah banget!
                                Patungan di sini bikin semua jadi mudah dan terpercaya."</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-7.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Allison Suzu</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Solusi buat yang mau langganan akun premium murah.
                                Proses cepat dan aman, Netflix dan Disney+ lancar!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Bottom-Slider" class="flex flex-row flex-nowrap group">
                <div class="flex flex-row gap-6 pr-6 w-max flex-nowrap animate-slide-left">
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-1.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Nabila Reyna</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Patungan akun di sini terpercaya, gak nyesel!
                                Netflix dan Disney+ lancar jaya, harga terjangkau pula!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-2.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bapak Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Hemat banget patungan akun di sini! Nonton Netflix
                                dan Spotify jadi lebih terjangkau. Proses cepat dan tanpa ribet!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-3.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Ibu Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">“Layanan patungan akun terbaik! Bisa langganan
                                Netflix dan Disney+ jadi lebih murah. Proses mudah dan aman, rekomendasi banget!”</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-4.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Murayiki Bazz</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Website ini bikin langganan lebih ringan di
                                kantong. Langsung bisa akses Disney+, Netflix, dan lainnya. Top deh!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-5.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bimore Atreidess</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Layanan top! Dulu nonton Netflix mahal, sekarang
                                lebih hemat dengan patungan akun. Proses gampang dan cepat!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-6.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Unil Utami</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Bisa nikmatin Spotify dan Disney+ murah banget!
                                Patungan di sini bikin semua jadi mudah dan terpercaya."</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-7.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Allison Suzu</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Solusi buat yang mau langganan akun premium murah.
                                Proses cepat dan aman, Netflix dan Disney+ lancar!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-6 pr-6 w-max flex-nowrap animate-slide-left">
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-1.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Nabila Reyna</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Patungan akun di sini terpercaya, gak nyesel!
                                Netflix dan Disney+ lancar jaya, harga terjangkau pula!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-2.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bapak Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Hemat banget patungan akun di sini! Nonton Netflix
                                dan Spotify jadi lebih terjangkau. Proses cepat dan tanpa ribet!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-3.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Ibu Budi</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">“Layanan patungan akun terbaik! Bisa langganan
                                Netflix dan Disney+ jadi lebih murah. Proses mudah dan aman, rekomendasi banget!”</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-4.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Murayiki Bazz</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Website ini bikin langganan lebih ringan di
                                kantong. Langsung bisa akses Disney+, Netflix, dan lainnya. Top deh!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-5.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Bimore Atreidess</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Layanan top! Dulu nonton Netflix mahal, sekarang
                                lebih hemat dengan patungan akun. Proses gampang dan cepat!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-6.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Unil Utami</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Bisa nikmatin Spotify dan Disney+ murah banget!
                                Patungan di sini bikin semua jadi mudah dan terpercaya."</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                    <div class="card flex flex-col w-[322px] h-full shrink-0 rounded-3xl p-6 gap-6 bg-white">
                        <div class="flex items-center gap-3">
                            <div class="flex w-16 h-16 overflow-hidden rounded-full shrink-0">
                                <img src="{{ asset('assets/images/photos/photo-7.png') }}"
                                    class="object-cover w-full h-full" alt="photos">
                            </div>
                            <div>
                                <p class="font-semibold text-lg leading-[22px]">Allison Suzu</p>
                                <p class="font-semibold leading-5 text-patungan-grey">Netflix Subscription</p>
                            </div>
                        </div>
                        <hr class="border-patungan-border">
                        <div class="flex flex-col justify-between h-full gap-6">
                            <p class="font-semibold leading-[28px]">"Solusi buat yang mau langganan akun premium murah.
                                Proses cepat dan aman, Netflix dan Disney+ lancar!"</p>
                            <div class="flex items-center gap-[2px]">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                                <img src="{{ asset('assets/images/icons/Star.svg') }}" class="flex w-6 shrink-0"
                                    alt="star">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Foreground"
                class="absolute bottom-0 w-full h-[457px] flex items-end justify-center bg-gradient-to-b from-transparent via-white/50 to-white z-10">
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
    <script src="js/accordion.js"></script>
    <script>
        const texts = document.querySelectorAll('#slider span');
        const sliderContainer = document.getElementById('slider-container');
        const slider = document.getElementById('slider');
        let currentIndex = 0;

        function updateSlider() {
            const currentText = texts[currentIndex];
            const containerWidth = currentText.offsetWidth;

            // Smoothly update the container's width
            sliderContainer.style.transition = 'width 300ms';
            sliderContainer.style.width = containerWidth + 'px';

            // Calculate the correct offset based on each text width
            let offset = 0;
            for (let i = 0; i < currentIndex; i++) {
                offset += texts[i].offsetWidth;
            }

            // Slide the text horizontally to the correct position
            slider.style.transform = `translateX(-${offset}px)`;

            // Move to the next text after 1s
            currentIndex = (currentIndex + 1) % texts.length;
        }

        // Set initial width and position on page load
        function setInitialWidth() {
            const firstText = texts[0];
            sliderContainer.style.width = firstText.offsetWidth + 'px';
        }

        // Ensure the width is correct when the page loads
        window.addEventListener('load', () => {
            setInitialWidth();
            // Start the slider interval after setting initial width
            setInterval(updateSlider, 2000);
        });
    </script>

</body>

</html>
