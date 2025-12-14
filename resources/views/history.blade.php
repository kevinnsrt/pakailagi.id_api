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
                            <td>{{ $item->status }}</td>
                            <td>
                                @if ($item->status == 'Dikeranjang')
                                    <a href="#" class="btn btn-sm btn-primary">Proses</a>
                                    <a href="#" class="btn btn-sm btn-primary">Batal</a>
                                @elseif ($item->status == 'Diproses')

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
