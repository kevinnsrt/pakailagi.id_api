<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Barang') }}
        </h2>
    </x-slot>

    @foreach ($data as $item)
   <div class="card bg-base-100 w-fit shadow-sm">
  <figure>
    <img
      src="{{ asset('storage/' . $item->image_path) }}"
      alt="Shoes" />
  </figure>
  <div class="card-body">
    <p class="font-bold text-lgx`">{{$item->name}}</p>
    <p>Deskripsi: {{ $item->deskripsi }}</p>
    <p>Kondisi: {{ $item->kondisi }}</p>
    <p>Harga:IDR {{ $item->price }}</p>
    <p>Ukuran: {{ $item->ukuran }}</p>
    <p>Kategori: {{ $item->kategori }}</p>

    <div class="card-actions justify-end">
      <button class="btn btn-primary w-36">Edit</button>
    </div>
  </div>
</div>

@endforeach
</x-app-layout>
