<nav x-data="{ 
        // Logic Desktop Slide (Hanya untuk Desktop)
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
                    <p class="ml-3 font-['Comfortaa'] text-[#3E8A8E] text-xl font-bold">
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
        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-40 pb-safe">
        <div class="flex justify-around items-center h-16 px-1">
            
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('dashboard') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            <a href="{{ route('tambah-barang') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('tambah-barang') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="text-[10px] font-medium">Tambah</span>
            </a>

            <a href="{{ route('barang') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('barang') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="text-[10px] font-medium">Produk</span>
            </a>

            <a href="{{ route('history.admin') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('history.admin') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="text-[10px] font-medium">Order</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('profile.edit') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300 {{ request()->routeIs('profile.edit') ? 'border-teal-500 ring-1 ring-teal-500' : '' }}">
                    <span class="text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <span class="text-[10px] font-medium">Akun</span>
            </a>

        </div>
    </div>
</nav>