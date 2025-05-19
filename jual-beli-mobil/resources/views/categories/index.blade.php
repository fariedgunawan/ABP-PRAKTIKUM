@extends('layouts.app')

@section('content')
<!-- AppBar Putih -->
<div class="bg-white shadow px-6 py-4 mb-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Daftar Kategori</h2>
</div>

<div class="max-w-6xl mx-auto px-4">

    <!-- Tombol untuk menambahkan kategori baru -->
    <div class="mb-4">
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Kategori -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Nama Kategori</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $category->name }}</td>
                    <td class="px-6 py-4">{{ $category->description }}</td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs font-medium transition">
                            Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-medium transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 italic">Belum ada kategori tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection
