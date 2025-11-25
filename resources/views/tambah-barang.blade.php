<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

<form method="POST" action="{{ route('tambah-barang-post') }}" enctype="multipart/form-data">
    @csrf
    <div class="flex justify-center mt-12">
    <div class="card bg-base-100 w-full max-w-lg shrink-0 shadow-2xl">
      <div class="card-body">
        <fieldset class="fieldset">
          <label class="label">Nama Barang</label>
          <input name="name" class="input" placeholder="Nama Barang" />
          <label class="label">Harga</label>
          <input name="price" type="number" class="input" placeholder="IDR"/>
          <label class="label">Ukuran</label>
          <input name="ukuran" class="input" placeholder="Ukuran"/>

        <label class="label">Deskripsi</label>
        <input name="deskripsi" class="input" placeholder="Deskripsi Barang" />

        
        <label class="label">Kondisi Barang</label>
        <select name="kondisi" id="kondisi">
        <option value="Like New">Like New</option>
        <option value="Good">Good</option>
        <option value="Fair">Fair</option>
        </select>

        <label class="label">Kategori</label>
        <select name="kategori" id="kategori">
        <option value="Atasan">Atasan</option>
        <option value="Bawahan">Bawahan</option>
        <option value="Outer">Outer</option>
        <option value="Tas">Tas</option>
        <option value="Sepatu">Sepatu</option>
        <option value="accessories">Accessories</option>
        <option value="Others">Others</option>
        </select>

        <label class="label">Foto Barang</label>
        <input name="image" type="file" class="file-input">

          <button class="btn btn-neutral mt-4">Tambah Barang</button>
        </fieldset>
</div>
</div>
</form>
</x-app-layout>