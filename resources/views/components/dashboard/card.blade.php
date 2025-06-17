@props([
    'icon' => 'box',
    'title' => '',
    'description' => '',
    'link' => null,
])

<div class="p-6 transition duration-300 bg-white shadow rounded-xl hover:shadow-md">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        <i data-lucide="{{ $icon }}" class="w-6 h-6 text-indigo-500"></i>
    </div>
    <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>

    @if ($link)
        <a href="{{ $link }}" class="inline-block mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-800">
            Lihat →</a>
    @endif
</div>
