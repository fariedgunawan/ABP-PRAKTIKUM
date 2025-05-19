@extends('layouts.app')

@section('content')
<!-- AppBar Putih -->
<div class="bg-white shadow px-6 py-4 mb-6 border-b">
    <h2 class="text-xl font-bold text-gray-800">Edit Pelanggan</h2>
</div>

<div class="max-w-xl mx-auto px-4">
    <div class="bg-white p-6 rounded-lg shadow">

        <!-- Menampilkan error validasi jika ada -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form edit pelanggan -->
        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan</label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $customer->name) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $customer->email) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                <input type="text" id="phone" name="phone"
                    value="{{ old('phone', $customer->phone) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" id="address" name="address"
                    value="{{ old('address', $customer->address) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('customers.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md transition">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-md transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
