@if ($paginator->hasPages())
    <nav class="flex items-center justify-between mt-6" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                    &larr; Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                    &larr; Sebelumnya
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 transition bg-white border border-gray-300 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                    Selanjutnya &rarr;
                </a>
            @else
                <span
                    class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed">
                    Selanjutnya &rarr;
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                        hingga
                        <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-semibold">{{ $paginator->total() }}</span> data
                </p>
            </div>

            <div>
                <span class="inline-flex items-center space-x-1 overflow-hidden border border-gray-300 rounded-lg">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="px-3 py-2 text-gray-400 bg-gray-100 cursor-not-allowed">&laquo;</span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="px-3 py-2 text-gray-700 transition bg-white hover:bg-blue-50 hover:text-blue-600">&laquo;</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="px-3 py-2 text-gray-400 bg-white">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="px-3 py-2 font-semibold text-white bg-blue-600">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-2 text-gray-700 transition bg-white hover:bg-blue-50 hover:text-blue-600">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}"
                            class="px-3 py-2 text-gray-700 transition bg-white hover:bg-blue-50 hover:text-blue-600">&raquo;</a>
                    @else
                        <span class="px-3 py-2 text-gray-400 bg-gray-100 cursor-not-allowed">&raquo;</span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
