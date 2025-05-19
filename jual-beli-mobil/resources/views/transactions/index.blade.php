@extends('layouts.app')

@section('content')
<div class="bg-white shadow-sm py-3 px-6 mb-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Daftar Transaksi</h2>
</div>

<div class="max-w-7xl mx-auto px-4">

    <!-- Tombol untuk menambahkan transaksi baru -->
    <a href="{{ route('transactions.create') }}"
       class="inline-block mb-4 px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
       Tambah Transaksi Baru
    </a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan tabel daftar transaksi -->
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Pelanggan</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Produk</th>
                    <th class="border border-gray-300 px-4 py-2 text-right">Total Harga</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Tanggal Transaksi</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->customer->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $transaction->product->name }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">{{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $transaction->transaction_date }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                           class="inline-block px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">
                           Edit
                        </a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Menampilkan pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
