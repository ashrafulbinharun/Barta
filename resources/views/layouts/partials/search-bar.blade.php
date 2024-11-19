<div class="flex items-center w-1/3 md:ml-24">
    <form action="{{ route('home') }}" method="GET" class="flex items-center w-full mx-auto">
        <label for="search" class="sr-only">Search</label>
        <div class="relative w-full">
            <input type="text" id="search" name="word" value="{{ request()->query('word') }}"
                class="bg-gray-50 border border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Search ..."
                required />
        </div>
        <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-black bg-white rounded-lg border border-gray-800 hover:bg-black hover:text-white">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d=" m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
            <span class="sr-only">Search</span>
        </button>
    </form>
</div>
