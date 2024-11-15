@props(['hasError' => false])

<div class="mt-2">
    <input
        {{ $attributes->merge([
            'class' =>
                'block w-full rounded-md border p-2 py-1.5 text-gray-900 shadow-sm placeholder:text-gray-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6',
            'border-red-600 focus:ring-red-600' => $hasError,
        ]) }} />
</div>
