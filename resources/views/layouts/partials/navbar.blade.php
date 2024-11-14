<nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <h2 class="text-2xl font-bold">Barta</h2>
                </a>
            </div>

            {{-- Search --}}
            <div class="flex items-center w-1/3 md:ml-24">
                <form action="{{ route('home') }}" method="GET" class="flex items-center w-full mx-auto">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" id="search" value="{{ request()->query('search') }}"
                            class="bg-gray-50 border
                            border-gray-800 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                            block w-full p-2.5"
                            name="search" placeholder="Search ..." required />
                    </div>
                    <button type="submit"
                        class="p-2.5 ms-2 text-sm font-medium text-black bg-white rounded-lg border border-gray-800 hover:bg-black hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d=" m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </form>
            </div>

            <div class="sm:ml-6 sm:flex sm:items-center">
                {{-- <a href="{{ route('posts.create') }}"
                    class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                    Create Post
                </a> --}}

                {{-- Profile dropdown  --}}
                <div class="relative ml-3" x-data="{ open: false }">
                    {{-- User Avatar --}}
                    <div>
                        <button @click="open = !open" type="button"
                            class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            @if (auth()->check())
                                <img class="w-8 h-8 rounded-full" src="{{ $user->get_avatar }}" alt="{{ $user->name }}" />
                            @else
                                <img class="w-8 h-8 rounded-full" src="https://avatars.githubusercontent.com/u/150423186?v=4" alt="Guest User" />
                            @endif
                        </button>
                    </div>

                    {{-- Dropdown menu  --}}
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                        @if (auth()->check())
                            {{-- {{ route('profile.index', auth()->user()->username) }} --}}
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                Your Profile
                            </a>
                            {{-- {{ route('profile.edit', auth()->user()->username) }} --}}
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
                                Edit Profile
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                                    id="user-menu-item-2">
                                    Sign out
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                Register
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center -mr-2 sm:hidden">
                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed -->
                    <svg x-show="!mobileMenuOpen" class="block w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                    <!-- Icon when menu is open -->
                    <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu, show/hide based on menu state.  --}}
    <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1">
            <a href="#" class="block py-2 pl-3 pr-4 text-base font-medium text-gray-700 border-l-4 border-gray-800 bg-gray-50">Discover</a>
            <a href="#"
                class="block py-2 pl-3 pr-4 text-base font-medium text-gray-500 border-l-4 border-transparent hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">For
                You</a>
            <a href="#"
                class="block py-2 pl-3 pr-4 text-base font-medium text-gray-500 border-l-4 border-transparent hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">People</a>
        </div>

        {{-- Profile dropdown  --}}
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                {{-- User Avatar --}}
                <div class="flex-shrink-0">
                    {{-- @if (auth()->check())
                        <img class="w-8 h-8 rounded-full" src="{{ auth()->user()->get_avatar }}" alt="{{ auth()->user()->name }}" />
                    @else
                        <img class="w-8 h-8 rounded-full" src="https://avatars.githubusercontent.com/u/150423186?v=4" alt="Guest User" />
                    @endif --}}
                </div>
                <div class="ml-3">
                    {{-- @if (auth()->check())
                        <h2 class="text-base font-medium text-gray-800">
                            {{ auth()->user()->name }}
                        </h2>
                        <p class="text-sm font-medium text-gray-500">
                            {{ auth()->user()->email }}
                        </p>
                    @else
                        <div class="text-base font-medium text-gray-800">
                            Ashraful Karim
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            ashrafulkarim.dev@gmail.com
                        </div>
                    @endif --}}
                </div>
            </div>
            {{-- Derpdown Menu --}}
            <div class="mt-3 space-y-1">
                {{-- @if (auth()->check())
                    <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Create
                        New Post
                    </a>
                    <a href="{{ route('profile.index', auth()->user()->username) }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Your
                        Profile
                    </a>
                    <a href="{{ route('profile.edit', auth()->user()->username) }}"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Edit
                        Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                            id="user-menu-item-2">
                            Sign out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Register
                    </a>
                @endif --}}
            </div>
        </div>
    </div>
</nav>
