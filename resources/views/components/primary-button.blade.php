<button type="submit"
    {{ $attributes->merge(['class' => 'flex items-center justify-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-gray-800 rounded-lg hover:bg-black']) }}>
    {{ $slot }}
</button>
