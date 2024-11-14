<footer class="mt-10 bg-black shadow">
    <div class="w-full max-w-screen-xl p-4 mx-auto md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0">
                <span class="self-center text-2xl font-semibold text-white whitespace-nowrap">Barta</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-100 sm:mb-0">
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">About</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-700 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-gray-200 sm:text-center">© {{ now()->year }}
            <a href="{{ route('home') }}" class="hover:underline">Barta</a>. All Rights
            Reserved.</span>
    </div>
</footer>
