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
        
        // Fungsi untuk mengatur posisi indikator slide
        indicatorStyle() {
            // Jika sedang hover, pakai index hover. Jika tidak, pakai index aktif.
            const index = this.hoverIndex !== null ? this.hoverIndex : this.activeIndex;
            
            // Jika tidak ada yang aktif (misal halaman lain), sembunyikan
            if (index === -1) return 'opacity: 0;';

            // Lebar dan posisi (asumsi tiap menu lebar & gap-nya konsisten, atau hitung manual)
            // Cara paling presisi adalah menggunakan $refs, tapi ini cara simpel via CSS grid/flex logic
            // Kita asumsikan setiap menu punya width yang flexible tapi container punya padding
            
            // NOTE: Agar animasi 'sliding pill' akurat, kita perlu binding ke elemen asli.
            // Di bawah ini kita gunakan pendekatan 'relative container' pada setiap link.
            return '';
        }
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

                <div class="hidden sm:ml-10 sm:flex sm:items-center relative" x-ref="navContainer">
                    
                    <div class="absolute h-9 bg-teal-50 rounded-lg border border-teal-100 transition-all duration-300 ease-out z-0"
                         x-show="hoverIndex !== null || activeIndex !== -1"
                         x-cloak
                         :style="(() => {
                             let targetIndex = hoverIndex !== null ? hoverIndex : activeIndex;
                             let refs = [$refs.link0, $refs.link1, $refs.link2, $refs.link3, $refs.link4];
                             let target = refs[targetIndex];
                             
                             if(!target) return 'opacity: 0';
                             
                             return `left: ${target.offsetLeft}px; width: ${target.offsetWidth}px; opacity: 1;`;
                         })()">
                    </div>

                    <div class="flex space-x-1 z-10">
                        <a href="{{ route('dashboard') }}" x-ref="link0"
                           @mouseenter="hoverIndex = 0" @mouseleave="hoverIndex = null"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                           :class="activeIndex === 0 ? 'text-teal-700' : (hoverIndex === 0 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">
                            {{ __('Dashboard') }}
                        </a>

                        <a href="{{ route('tambah-barang') }}" x-ref="link1"
                           @mouseenter="hoverIndex = 1" @mouseleave="hoverIndex = null"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                           :class="activeIndex === 1 ? 'text-teal-700' : (hoverIndex === 1 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">
                            {{ __('Tambah Barang') }}
                        </a>

                        <a href="{{ route('barang') }}" x-ref="link2"
                           @mouseenter="hoverIndex = 2" @mouseleave="hoverIndex = null"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                           :class="activeIndex === 2 ? 'text-teal-700' : (hoverIndex === 2 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">
                            {{ __('Barang') }}
                        </a>

                        <a href="{{ route('history.admin') }}" x-ref="link3"
                           @mouseenter="hoverIndex = 3" @mouseleave="hoverIndex = null"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                           :class="activeIndex === 3 ? 'text-teal-700' : (hoverIndex === 3 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">
                            {{ __('History') }}
                        </a>

                        <a href="{{ route('promosi.index') }}" x-ref="link4"
                           @mouseenter="hoverIndex = 4" @mouseleave="hoverIndex = null"
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
                           :class="activeIndex === 4 ? 'text-teal-700' : (hoverIndex === 4 ? 'text-teal-600' : 'text-gray-500 hover:text-gray-700')">
                            {{ __('Promosi') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-gray-50 hover:text-teal-600 hover:bg-teal-50 focus:outline-none transition ease-in-out duration-150 group">
                            <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-xs mr-2 border border-teal-200 group-hover:bg-teal-200 transition">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-teal-500 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-teal-600 hover:bg-teal-50 focus:outline-none focus:bg-teal-50 focus:text-teal-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden bg-gray-50 border-t border-gray-100">
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tambah-barang')" :active="request()->routeIs('tambah-barang')">
                {{ __('Tambah Barang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('barang')" :active="request()->routeIs('barang')">
                {{ __('Barang') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('history.admin')" :active="request()->routeIs('history.admin')">
                {{ __('History Pesanan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('promosi.index')" :active="request()->routeIs('promosi.index')">
                {{ __('Promosi') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-white">
            <div class="px-4 flex items-center">
                 <div class="shrink-0 mr-3">
                    <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-lg">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>