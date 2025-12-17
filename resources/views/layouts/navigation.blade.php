<nav x-data="{ 
        // Logic Desktop Slide
        activeIndex: {{ 
            request()->routeIs('dashboard') ? 0 : 
            (request()->routeIs('tambah-barang') ? 1 : 
            (request()->routeIs('barang') ? 2 : 
            (request()->routeIs('history.admin') ? 3 : 
            (request()->routeIs('promosi.index') ? 4 : -1)))) 
        }},
        hoverIndex: null,

        // Logic Mobile Bottom Sheet
        mobileMenuOpen: false 
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

            <button @click="mobileMenuOpen = true" 
                    class="flex flex-col items-center justify-center w-full h-full space-y-1 focus:outline-none {{ request()->routeIs('profile.edit') ? 'text-teal-600' : 'text-gray-400 hover:text-gray-600' }}">
                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-300 {{ request()->routeIs('profile.edit') || 'mobileMenuOpen' ? 'border-teal-500 ring-1 ring-teal-500' : '' }}">
                    <span class="text-xs font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <span class="text-[10px] font-medium">Akun</span>
            </button>

        </div>
    </div>

    <div class="relative z-[60] md:hidden" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true" 
         x-show="mobileMenuOpen" 
         style="display: none;">
        
        <div x-show="mobileMenuOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
             @click="mobileMenuOpen = false"></div>

        <div class="fixed inset-x-0 bottom-0 z-10 w-full overflow-hidden bg-white rounded-t-2xl shadow-2xl pb-safe"
             x-show="mobileMenuOpen"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full">
            
            <div class="p-4 sm:p-6">
                <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-6"></div>

                <div class="flex items-center space-x-4 mb-6">
                    <div class="h-12 w-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xl border border-teal-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center w-full px-4 py-3 text-left text-sm font-medium text-gray-700 bg-gray-50 hover:bg-teal-50 hover:text-teal-700 rounded-xl transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Edit Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-3 text-left text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Log Out
                        </button>
                    </form>
                </div>

                <button @click="mobileMenuOpen = false" class="mt-6 w-full py-3 text-sm font-semibold text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</nav>