@extends('layouts.app')

@section('content')

<div class="bg-white shadow-sm py-3 px-6 mb-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Daftar Pelanggan</h2>
</div>

<div class="max-w-6xl mx-auto px-4">

    <!-- Tombol untuk menambahkan Pelanggan baru -->
    <a href="{{ route('customers.create') }}"
        class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        Tambah Pelanggan Baru
    </a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel daftar pelanggan -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 border-b border-gray-300">Nama</th>
                    <th class="text-left px-4 py-3 border-b border-gray-300">Email</th>
                    <th class="text-left px-4 py-3 border-b border-gray-300">No Telepon</th>
                    <th class="text-left px-4 py-3 border-b border-gray-300">Alamat</th>
                    <th class="text-left px-4 py-3 border-b border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border-b border-gray-200">{{ $customer->name }}</td>
                    <td class="px-4 py-3 border-b border-gray-200">{{ $customer->email }}</td>
                    <td class="px-4 py-3 border-b border-gray-200">{{ $customer->phone }}</td>
                    <td class="px-4 py-3 border-b border-gray-200">{{ $customer->address }}</td>
                    <td class="px-4 py-3 border-b border-gray-200 space-x-2">

                        <a href="{{ route('customers.edit', $customer->id) }}"
                            class="inline-block px-3 py-1 text-sm bg-yellow-400 text-yellow-900 rounded hover:bg-yellow-500 transition">
                            Edit
                        </a>

                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')"
                                class="inline-block px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $customers->links('pagination::tailwind') }}
    </div>
</div>

@endsection
