@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800']) }}>
    {{ $slot }}
</a>
