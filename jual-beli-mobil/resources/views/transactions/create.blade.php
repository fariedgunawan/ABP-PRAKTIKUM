@extends('layouts.app')

@section('content')
<!-- AppBar Putih -->
<div class="bg-white shadow-sm py-3 px-6 mb-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Tambah Transaksi Baru</h2>
</div>

<div class="max-w-3xl mx-auto px-4">
    <div class="bg-white p-6 rounded-lg shadow-sm">

        <!-- Menampilkan error validasi jika ada -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form untuk menambahkan transaksi baru -->
        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf

            <div class="mb-5">
                <label for="customer_id" class="block mb-2 font-semibold text-gray-700">Pelanggan</label>
                <select id="customer_id" name="customer_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="product_id" class="block mb-2 font-semibold text-gray-700">Produk</label>
                <select id="product_id" name="product_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="quantity" class="block mb-2 font-semibold text-gray-700">Jumlah Produk</label>
                <input type="number" id="quantity" name="quantity" min="1" required
                    value="{{ old('quantity', 1) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="transaction_date" class="block mb-2 font-semibold text-gray-700">Tanggal Transaksi</label>
                <input type="date" id="transaction_date" name="transaction_date" required
                    value="{{ old('transaction_date') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('transactions.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
