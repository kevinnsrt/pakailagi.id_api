<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pesanan') }}
        </h2>
    </x-slot>

    <div class="flex justify-center w-full min-h-screen p-4">
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 w-full max-w-6xl">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Pesanan</th>
                        <th>Lokasi</th>
                        <th></th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>{{ $item->product->name ?? '-' }}</td>
                            <td>{{ $item->user->latitude ?? '-' }}</td>
                            <td>{{ $item->user->longitude ?? '-' }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @if ($item->status == 'Dikeranjang')
                                    
                                @elseif ($item->status == 'Diproses')
                                {{-- form proses pesanan --}}
                                {{-- buat push notification --}}
                                    <form method="POST" action="{{ route('proses.pesanan',$item->id) }}">
                                        @csrf
                                        {{-- <input type="hidden" name="id" value="{{ $item->id }}"> --}}
                                        <button type="submit" class="btn btn-sm btn-primary">Proses</button>
                                    </form>

                                    {{-- form batal pesanan --}}
                                    <form method="POST" action="{{ route('batal.pesanan',$item->id) }}">
                                        @csrf
                                        {{-- <input type="hidden" name="id" value="{{ $item->id }}"> --}}
                                        <button type="submit" class="btn btn-sm btn-error">Batal</button>
                                    </form>
                                @endif
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
