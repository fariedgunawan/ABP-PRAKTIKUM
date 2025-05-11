@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar Produk</h1>

    <!-- Tombol untuk menambahkan produk baru -->
    <a href="{{ route('products.create') }}"
       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded mb-6">
        + Tambah Produk Baru
    </a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan tabel daftar produk -->
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Harga</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kategori</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $product->description }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $product->category->name }}</td>
                    <td class="px-6 py-4 text-sm text-center space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
