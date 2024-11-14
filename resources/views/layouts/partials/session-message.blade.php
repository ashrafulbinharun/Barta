<div>
    @if (session()->has('message'))
        <div class="flex items-center justify-center p-4 mb-4 text-sm font-medium text-green-800 border-2 border-green-300 rounded-lg bg-green-50" role="alert">
            <span class="sr-only">Success</span>
            <div class="text-center">{{ session('message') }}</div>
        </div>
    @endif
</div>
