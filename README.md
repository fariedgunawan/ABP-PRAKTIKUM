
# Praktikum Modul 1 ABP

🛠️ Langkah-langkah Instalasi

Install PHP dari C:/xampp/php dan tambahkan ke Environment Variable

Install Composer dari https://getcomposer.org/Composer-Setup.exe

## Installation Laravel

```bash
composer global require laravel/installer
```
```bash
laravel new relasi-demo
cd relasi-demo
```

## Setup .env terlebih dulu
```javascript
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=praktikumabp
DB_USERNAME=root
DB_PASSWORD=
```
## Buat Model dan Migration
```bash
php artisan make:model Category -m
php artisan make:model Product -m
```
## Edit File Migration
📁 database/migrations/xxxx_xx_xx_create_categories_table.php
```javascript
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```
📁 database/migrations/xxxx_xx_xx_create_products_table.php
```javascript
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->decimal('price', 8, 2);
    $table->timestamps();
});
```
## Migrasi Ke DB
```bash
php artisan migrate
```
## Relationship Model
📁 app/Models/Category.php
```javascript
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```
app/Models/Product.php
```javascript
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

```
## Buat Seeder untuk data Dummy
```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder ProductSeeder
```
📁 database/seeders/CategorySeeder.php
```javascript
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Clothing']);
    }
}
```
database/seeders/ProductSeeder.php
```javascript
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'name' => 'Smartphone',
            'price' => 699.99
        ]);

        Product::create([
            'category_id' => 1,
            'name' => 'Laptop',
            'price' => 999.99
        ]);

        Product::create([
            'category_id' => 2,
            'name' => 'T-shirt',
            'price' => 19.99
        ]);
    }
}
```
📁 database/seeders/DatabaseSeeder.php
```javascript
public function run(): void
{
    $this->call([
        CategorySeeder::class,
        ProductSeeder::class,
    ]);
}
```

## Jalankan Seeder
```bash
php artisan db:seed
```

## Buat Route methode GET
📁 routes/web.php
```javascript
use App\Models\Category;

Route::get('/api/categories', function () {
    return Category::with('products')->get();
});
```

## Jalankan Laravel
```bash
php artisan serve
```

## Anda bisa mengaksesnya link seperti dibawah ini

http://localhost:8000/api/categories

## Pastikan XAMPP Nyala ya ges


# Praktikum Modul 2 ABP (Ini sih keknya CRUD nya ga semua)

## Tambahkan Route dulu
📁 routes/web.php
```javascript
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
Route::get('get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
```
## Buat Controllers
```bash
php artisan make:controller ProductController
```
## Isi productcontroller tsb dengan
📁 app/Http/Controllers/ProductController.php
```javascript
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('products.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $product = Product::updateOrCreate(
            ['id' => $request->product_id],
            [
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }

    public function getProducts()
    {
        $products = Product::with('category')->get();
        return datatables()->of($products)
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-primary btn-sm editProduct">Edit</a> ';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
```
## Buat Viewnya
📁 resources/views/products/index.blade.php
```javascript
<!DOCTYPE html>
<html>
<head>
    <title>Laravel AJAX Product CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Product List</h2>
    <button class="btn btn-success mb-3" id="createNewProduct">Add Product</button>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="productForm">
        <div class="modal-header">
            <h4 class="modal-title">Add/Edit Product</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="product_id" id="product_id">
            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" class="form-control" id="price" name="price" required step="0.01">
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
$(function () {
    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.getProducts') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'category.name', name: 'category.name' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#createNewProduct').click(function () {
        $('#productForm').trigger("reset");
        $('#product_id').val('');
        $('#productModal').modal('show');
    });

    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#productForm').serialize(),
            url: "{{ route('products.store') }}",
            type: "POST",
            success: function () {
                $('#productModal').modal('hide');
                table.draw();
            }
        });
    });

    $('body').on('click', '.editProduct', function () {
        let id = $(this).data('id');
        $.get("products/" + id, function (data) {
            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#price').val(data.price);
            $('#category_id').val(data.category_id);
            $('#productModal').modal('show');
        });
    });

    $('body').on('click', '.deleteProduct', function () {
        let id = $(this).data("id");
        if (confirm("Are You sure want to delete !")) {
            $.ajax({
                type: "DELETE",
                url: "products/" + id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    table.draw();
                }
            });
        }
    });
});
</script>
</body>
</html>
```
## Buat Methode show di product
📁 app/Http/Controllers/ProductController.php
```javascript
public function show($id)
{
    return Product::find($id);
}
```

## Tambahin CSRF Protection di View 
📁 resources/views/products/index.blade.php

### Tambahin dibagian <head><head/>
```javascript
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Tambahin Ajax di script
```javascript
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.getProducts') }}",
        ...
```

## Silahkan Jalankan Laravelnya
```bash
php artisan serve
```

## Akses Domain
http://localhost:8000/products

## Kalo masih ada pesan gagal/eror ikutin Instalasi dibawah ini
```bash
composer require yajra/laravel-datatables-oracle
```
## Tambahin script ini di config/app.php
```javascript
'providers' => [

    /*
     * Package Service Providers...
     */
    Yajra\DataTables\DataTablesServiceProvider::class, //Letakkan disini

    /*
     * Application Service Providers...
     */
    App\Providers\AppServiceProvider::class,
    // ...
],
```
## Jalankan
```bash
php artisan vendor:publish --provider="Yajra\DataTables\DataTablesServiceProvider"
```
## Silahkan cek lagi harusnya bisa 😂
