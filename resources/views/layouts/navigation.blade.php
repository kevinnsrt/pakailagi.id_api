<nav x-data="{ 
        open: false,
        activeIndex: {{ 
            request()->routeIs('dashboard') ? 0 : 
            (request()->routeIs('tambah-barang') ? 1 : 
            (request()->routeIs('barang') ? 2 : 
            (request()->routeIs('history.admin') ? 3 : 
            (request()->routeIs('promosi.index') ? 4 : -1)))) 
        }},
        hoverIndex: null,
    }" 
    class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Aplikasi" class="block h-9 w-auto" />
                    </a>
                    <p class="ml-3 font-['Comfortaa'] text-[#3E8A8E] text-xl font-bold hidden md:block">
                        pakailagi.id
                    </p>
                </div>

                <div class="hidden sm:ml-10 sm:flex sm:items-center relative h-full" x-ref="navContainer">
                    <div class="absolute bottom-0 h-1 bg-teal-600 rounded-full transition-all duration-300 ease-out z-0 pointer-events-none"
                         x-show="hoverIndex !== null || activeIndex !== -1"
                         x-cloak
                         :style="(() => {
                             let targetIndex = hoverIndex !== null ? hoverIndex : activeIndex;
                             let refs = [$refs.link0, $refs.link1, $refs.link2, $refs.link3, $refs.link4];
                             let target = refs[targetIndex];
                             if(!target) return 'opacity: 0';
                             return `left: ${target.offsetLeft + 4}px; width: ${target.offsetWidth - 8}px; opacity: 1;`;
                         })()">
                    </div>

                    <div class="flex space-x-1 h-full items-center">
                        <a href="{{ route('dashboard') }}" x-ref="link0" @mouseenter="hoverIndex = 0" @mouseleave="hoverIndex = null" class="px-4 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center h-full border-b-2 border-transparent" :class="activeIndex === 0 ? 'text-teal-700 font-bold' : (hoverIndex === 0 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">{{ __('Dashboard') }}</a>
                        <a href="{{ route('tambah-barang') }}" x-ref="link1" @mouseenter="hoverIndex = 1" @mouseleave="hoverIndex = null" class="px-4 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center h-full border-b-2 border-transparent" :class="activeIndex === 1 ? 'text-teal-700 font-bold' : (hoverIndex === 1 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">{{ __('Tambah Barang') }}</a>
                        <a href="{{ route('barang') }}" x-ref="link2" @mouseenter="hoverIndex = 2" @mouseleave="hoverIndex = null" class="px-4 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center h-full border-b-2 border-transparent" :class="activeIndex === 2 ? 'text-teal-700 font-bold' : (hoverIndex === 2 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">{{ __('Barang') }}</a>
                        <a href="{{ route('history.admin') }}" x-ref="link3" @mouseenter="hoverIndex = 3" @mouseleave="hoverIndex = null" class="px-4 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center h-full border-b-2 border-transparent" :class="activeIndex === 3 ? 'text-teal-700 font-bold' : (hoverIndex === 3 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">{{ __('History') }}</a>
                        <a href="{{ route('promosi.index') }}" x-ref="link4" @mouseenter="hoverIndex = 4" @mouseleave="hoverIndex = null" class="px-4 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center h-full border-b-2 border-transparent" :class="activeIndex === 4 ? 'text-teal-700 font-bold' : (hoverIndex === 4 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">{{ __('Promosi') }}</a>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-gray-50 hover:text-teal-600 hover:bg-teal-50 focus:outline-none transition ease-in-out duration-150 group">
                            <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-xs mr-2 border border-teal-200 group-hover:bg-teal-200 transition">{{ substr(Auth::user()->name, 0, 1) }}</div>
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-teal-500 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50">{{ __('Log Out') }}</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = true" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-teal-600 hover:bg-teal-50 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="relative z-50 sm:hidden" role="dialog" aria-modal="true" x-show="open" style="display: none;">
        <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="open = false"></div>

        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-10">
                    <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="pointer-events-auto relative w-screen max-w-xs">
                        
                        <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                            <div class="px-4 sm:px-6 mb-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto mr-2">
                                    <h2 class="text-xl font-bold text-teal-600 font-['Comfortaa']">pakailagi.id</h2>
                                </div>
                                <button @click="open = false" type="button" class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            
                            <div class="relative mt-2 flex-1 px-4 sm:px-6 space-y-2">
                                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-lg">
                                    {{ __('Dashboard') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('tambah-barang')" :active="request()->routeIs('tambah-barang')" class="rounded-lg">
                                    {{ __('Tambah Barang') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('barang')" :active="request()->routeIs('barang')" class="rounded-lg">
                                    {{ __('Barang') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('history.admin')" :active="request()->routeIs('history.admin')" class="rounded-lg">
                                    {{ __('History Pesanan') }}
                                </x-responsive-nav-link>
                                <x-responsive-nav-link :href="route('promosi.index')" :active="request()->routeIs('promosi.index')" class="rounded-lg">
                                    {{ __('Promosi') }}
                                </x-responsive-nav-link>

                                <hr class="border-gray-100 my-4">

                                <div class="bg-gray-50 rounded-xl p-4 mt-4">
                                    <div class="flex items-center mb-3">
                                        <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold mr-3">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                    <x-responsive-nav-link :href="route('profile.edit')" class="justify-center text-center rounded-lg bg-white border border-gray-200 mb-2">
                                        {{ __('Edit Profile') }}
                                    </x-responsive-nav-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-center py-2 bg-white border border-red-100 text-red-600 rounded-lg text-sm font-medium shadow-sm hover:bg-red-50 transition">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>