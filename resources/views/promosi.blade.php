<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Promosi & Notifikasi') }}
        </h2>
    </x-slot>

    @if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Promosi Baru</h3>
                    
                    <form action="{{ route('promosi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Judul Promosi</label>
                            <input type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Diskon Akhir Tahun!" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Isi Pesan</label>
                            <textarea name="body" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Dapatkan potongan harga 50%..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Banner</label>
                            <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100" required>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kirim Notifikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Promosi</h3>
                    
                    <div class="space-y-4">
@forelse($data as $promo)
                            <div class="flex items-start border-b border-gray-100 pb-4">
                                <img src="{{ asset('storage/' . $promo->image_path) }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-800">{{ $promo->title }}</h4>
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $promo->body }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $promo->created_at->diffForHumans() }}</p>
                                </div>
                                
                                <div class="flex flex-col space-y-2 ml-2">
                                    <form action="{{ route('promosi.resend', $promo->id) }}" method="POST" onsubmit="return confirm('Kirim ulang notifikasi ini ke semua user?');">
                                        @csrf
                                        <button type="submit" class="text-blue-500 hover:text-blue-700" title="Kirim Ulang Notifikasi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                            </svg>
                                        </button>
                                    </form>

                                    <form action="{{ route('promosi.destroy', $promo->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat promosi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus Riwayat">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center">Belum ada promosi yang dibuat.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>