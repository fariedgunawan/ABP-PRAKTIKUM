
# Praktikum 2 ABP

🛠️ Langkah-langkah Instalasi

Install PHP dari C:/xampp/php dan tambahkan ke Environment Variable

Install Composer dari https://getcomposer.org/Composer-Setup.exe

## Installation Laravel

```bash
composer create-project laravel/laravel jual-beli-mobil
cd jual-beli-mobil
```
Buat database di local kalian namanya jualbelimobil
## Setup .env terlebih dulu
```javascript
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=jualbelimobil
DB_USERNAME=root
DB_PASSWORD=
```

## INI JEBAKAN GES 
Buat dulu Category, karena kalo ikutin kea di modul itu pasti eror karena gimana caranya category belom ada tpi product minta FK Category by id :))
## Buat Model dan Migration  untuk **Category aja**
```bash
php artisan make:model Category -m
```
## Edit File Migration untuk **Category aja** 
📁 database/migrations/xxxx_xx_xx_create_categories_table.php
```javascript
Schema::create('categories', function (Blueprint $table) {
    $table->id(); // Kolom ID unik untuk setiap kategori
    $table->string('name'); // Nama kategori, tipe data string
    $table->text('description')->nullable(); // Deskripsi kategori, opsional, tipe data text
    $table->timestamps(); // Kolom untuk mencatat waktu pembuatan dan perubahan data
});
```
## Migrasi Ke DB untuk **Category aja** 
```bash
php artisan migrate
```
## Buat Model dan Migration yang lainnya
```bash
php artisan make:model Product -m
php artisan make:model Customer -m
php artisan make:model Transaction -m
```
## Edit File Migration sisanya
📁 database/migrations/xxxx_xx_xx_create_products_table.php
```javascript
Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom ID unik untuk setiap produk
            $table->string('name'); // Nama produk, tipe data string
            $table->text('description'); // Deskripsi produk, tipe data text
            $table->decimal('price', 10, 2); // Harga produk, tipe data decimal dengan 10 digit total dan 2 digit setelah koma
            $table->unsignedBigInteger('category_id'); // ID dari kategori produk, tipe data unsignedBigInteger
            $table->timestamps(); // Kolom untuk mencatat waktu pembuatan dan perubahan data

            // Relasi antara produk dan kategori (Foreign Key)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
```

📁 database/migrations/xxxx_xx_xx_create_costumers_table.php
```javascript
 Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Kolom ID unik untuk setiap customer
            $table->string('name'); // Nama customer, tipe data string
            $table->string('email')->unique(); // Email customer, tipe data string, harus unik
            $table->string('phone'); // Nomor telepon customer, tipe data string
            $table->text('address'); // Alamat customer, tipe data text
            $table->timestamps(); // Kolom untuk mencatat waktu pembuatan dan perubahan data
        });
```

📁 database/migrations/xxxx_xx_xx_create_transactions_table.php
```javascript
Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Kolom ID unik untuk setiap transaksi
            $table->unsignedBigInteger('customer_id'); // ID dari customer yang melakukan transaksi
            $table->unsignedBigInteger('product_id'); // ID dari produk yang dibeli
            $table->decimal('total_price', 10, 2); // Total harga transaksi, tipe data decimal
            $table->date('transaction_date'); // Tanggal transaksi, tipe data date
            $table->timestamps(); // Kolom untuk mencatat waktu pembuatan dan perubahan data

            // Relasi ke tabel customers dan products
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
```
## Migrasi Ke DB sisanya
```bash
php artisan migrate
```
## Relationship Model
📁 app/Models/Product.php
```javascript
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    // Relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke tabel transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
```
app/Models/Category.php
```javascript
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = ['name', 'description'];

    // Relasi ke tabel products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```
app/Models/Customer.php
```javascript
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = ['name', 'email', 'phone', 'address'];

    // Relasi ke tabel transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
```
app/Models/Transaction.php
```javascript
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Kolom yang boleh diisi secara massal
    protected $fillable = ['customer_id', 'product_id', 'total_price', 'transaction_date'];

    // Relasi ke tabel customers
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke tabel products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
```

## Buat Seeder untuk data Dummy khusus Category biar ga kosong2 amat
```bash
php artisan make:seeder CategorySeeder
```
📁 database/seeders/CategorySeeder.php
```javascript
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Mobil Baru',
                'description' => 'Kategori untuk mobil yang masih baru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobil Bekas',
                'description' => 'Kategori untuk mobil bekas atau second hand',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobil Listrik',
                'description' => 'Kategori untuk mobil listrik ramah lingkungan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
```
📁 database/seeders/DatabaseSeeder.php
```javascript
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run(): void
{
    $this->call([
        CategorySeeder::class,
    ]);
}
}
```
## Jalankan Seeder
```bash
php artisan db:seed
```
## Instalasi Laravel Breeze
note : lakuin 1 1 ya jangan langsung copy aja
```bash
composer require laravel/breeze --dev
php artisan breeze:install
```
Kalo ada pilihan ini pilih blade trus yes yes aja
```bash
Which stack would you like to install?
  blade .......................................................................................................................................... 0
  react .......................................................................................................................................... 1
  vue ............................................................................................................................................ 2  
  api ............................................................................................................................................ 3
```
```bash
npm install
npm run dev
```
Setelah npm run dev, buka terminal baru yang penting directorynya masih sama dalam hal ini brati jual-beli-mobil, yang tadi jangan di terminate

## Kalo perlu aja (misal tadi lupa migrate)
```bash
php artisan migrate
```

## Jalanin buat login sama register bawaan breeze
```bash
php artisan serve
```
akses di http://127.0.0.1:8000/login untuk login / http://127.0.0.1:8000/register untuk regis

## Buat tampilan UI
buat folder baru namanya product di
📁 resource/views/products

buat create.blade.php di folder tsb
📁 resource/views/products/create.blade.php
```javascript
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk Baru</h1>

    <!-- Menampilkan error validasi jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form untuk menambahkan produk baru -->
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga Produk</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori Produk</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
```
buat index.blade.php di folder tsb
📁 resource/views/products/index.blade.php
```javascript
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>

    <!-- Tombol untuk menambahkan produk baru -->
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Tambah Produk Baru</a>

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan tabel daftar produk -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Menampilkan pagination -->
    {{ $products->links() }}
</div>
@endsection
```
buat edit.blade.php di folder tsb
📁 resource/views/products/edit.blade.php
```javascript
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>

    <!-- Menampilkan error validasi jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form untuk mengedit produk -->
    <form method="POST" action="{{ route('products.update', $product->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" id="description" name="description" required>{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga Produk</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori Produk</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
```
## DISINI ADA JEBAKAN :))
edit app.blade.php
📁 resource/views/layouts/app.blade.php
```javascript
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="p-6 bg-white shadow-md rounded-md max-w-7xl mx-auto mt-6">
                @yield('content') // diganti jadi ini
            </main>
        </div>
    </body>
</html>
```

## Buat Controller 
```bash
php artisan make:controller ProductController
php artisan make:controller CategoryController
php artisan make:controller TransactionController
php artisan make:controller CostumerController
```

## Konfigurasi Routes
📁 routes/web.php
```javascript
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Definisikan resource route untuk produk
Route::resource('products', ProductController::class);

// Definisikan resource route untuk pelanggan
Route::resource('customers', CustomerController::class);

// Definisikan resource route untuk transaksi
Route::resource('transactions', TransactionController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
```
## Konfigurasi Controller
📁 app/http/controllers/ProductController.php
```javascript
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk (Read)
    public function index()
    {
        // Mengambil semua produk dari database dan mem-paginate 10 data per halaman
        $products = Product::with('category')->paginate(10);

        // Return view dengan data produk
        return view('products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru (Create)
    public function create()
    {
        // Mengambil semua kategori untuk ditampilkan pada form select
        $categories = Category::all();

        // Return view untuk menampilkan form
        return view('products.create', compact('categories'));
    }

    // Menyimpan data produk baru ke database (Store)
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Menyimpan produk baru ke database
        Product::create($request->all());

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit produk yang ada (Edit)
    public function edit($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Ambil semua kategori untuk form select
        $categories = Category::all();

        // Return view dengan data produk yang akan di-edit
        return view('products.edit', compact('product', 'categories'));
    }

    // Memperbarui data produk di database (Update)
    public function update(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Update produk di database
        $product->update($request->all());

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate.');
    }

    // Menghapus produk dari database (Delete)
    public function destroy($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hapus produk dari database
        $product->delete();

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
```
📁 app/http/controllers/CategoryController.php
```javascript
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
```
📁 app/http/controllers/CostumerController.php
```javascript
<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Menampilkan daftar pelanggan (Read)
    public function index()
    {
        // Mengambil semua data pelanggan dan mem-paginate 10 data per halaman
        $customers = Customer::paginate(10);

        // Return view dengan data pelanggan
        return view('customers.index', compact('customers'));
    }

    // Menampilkan form untuk membuat pelanggan baru (Create)
    public function create()
    {
        // Return view untuk menampilkan form pendaftaran pelanggan baru
        return view('customers.create');
    }

    // Menyimpan data pelanggan baru ke database (Store)
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Menyimpan data pelanggan baru ke database
        Customer::create($request->all());

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit pelanggan (Edit)
    public function edit($id)
    {
        // Cari pelanggan berdasarkan ID
        $customer = Customer::findOrFail($id);

        // Return view untuk mengedit data pelanggan
        return view('customers.edit', compact('customer'));
    }

    // Memperbarui data pelanggan di database (Update)
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Cari pelanggan berdasarkan ID
        $customer = Customer::findOrFail($id);

        // Update data pelanggan di database
        $customer->update($request->all());

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diupdate.');
    }

    // Menghapus pelanggan dari database (Delete)
    public function destroy($id)
    {
        // Cari pelanggan berdasarkan ID
        $customer = Customer::findOrFail($id);

        // Hapus pelanggan dari database
        $customer->delete();

        // Redirect ke halaman daftar pelanggan dengan pesan sukses
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
```

📁 app/http/controllers/TransactionController.php
```javascript
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi (Read)
    public function index()
    {
        // Mengambil semua data transaksi beserta relasi ke customer dan produk
        $transactions = Transaction::with(['customer', 'product'])->paginate(10);

        // Return view dengan data transaksi
        return view('transactions.index', compact('transactions'));
    }

    // Menampilkan form untuk membuat transaksi baru (Create)
    public function create()
    {
        // Mengambil semua customer dan product untuk form select
        $customers = Customer::all();
        $products = Product::all();

        // Return view untuk menampilkan form
        return view('transactions.create', compact('customers', 'products'));
    }

    // Menyimpan data transaksi baru ke database (Store)
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'total_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);

        // Menyimpan transaksi baru ke database
        Transaction::create($request->all());

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit transaksi yang ada (Edit)
    public function edit($id)
    {
        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Ambil semua customer dan product untuk form select
        $customers = Customer::all();
        $products = Product::all();

        // Return view untuk mengedit transaksi
        return view('transactions.edit', compact('transaction', 'customers', 'products'));
    }

    // Memperbarui data transaksi di database (Update)
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'total_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Update data transaksi di database
        $transaction->update($request->all());

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    // Menghapus transaksi dari database (Delete)
    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($id);

        // Hapus transaksi dari database
        $transaction->delete();

        // Redirect ke halaman daftar transaksi dengan pesan sukses
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
```

## Running deh semoga bisa
Running di localhost http://127.0.0.1:8000/products

jangan lupa lakuin login dan register sebelumnya yang udah gua kasih tau
karena kalo ga login kaga bakal bisa

BTW kalo mau lucu tampilannya make tailwind liat source code gua aja bagian folder resource/views/products (isinya samain aja kea punya gua di source code github gua)

SEMANGAT KAWAN 😍
