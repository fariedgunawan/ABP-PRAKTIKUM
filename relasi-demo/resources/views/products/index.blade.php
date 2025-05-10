<!DOCTYPE html>
<html>
<head>
    <title>Laravel AJAX Product CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container mt-4">
    <h2>Product Management (AJAX)</h2>
    <button class="btn btn-success mb-3" id="createNewProduct">Add Product</button>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Category</th>
                <th>Name</th>
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
            <h4 class="modal-title" id="modalHeading">Add/Edit Product</h4>
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
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'category.name', name: 'category.name' },
            { data: 'name', name: 'name' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#createNewProduct').click(function () {
        $('#productForm').trigger("reset");
        $('#product_id').val('');
        $('#modalHeading').text('Create New Product');
        $('#productModal').modal('show');
    });

    $('#productForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#productForm').serialize(),
            url: "{{ route('products.store') }}",
            type: "POST",
            success: function () {
                $('#productForm').trigger("reset");
                $('#productModal').modal('hide');
                table.draw();
            },
            error: function (xhr) {
                console.log('Error:', xhr.responseJSON);
            }
        });
    });

    $('body').on('click', '.editProduct', function () {
        let id = $(this).data('id');
        $.get("{{ url('products') }}/" + id + "/edit", function (data) {
            $('#modalHeading').text('Edit Product');
            $('#product_id').val(data.id);
            $('#name').val(data.name);
            $('#price').val(data.price);
            $('#category_id').val(data.category_id);
            $('#productModal').modal('show');
        });
    });

    $('body').on('click', '.deleteProduct', function () {
        let id = $(this).data("id");
        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('products') }}/" + id,
                success: function () {
                    table.draw();
                },
                error: function (xhr) {
                    console.log('Delete Error:', xhr.responseJSON);
                }
            });
        }
    });
});
</script>
</body>
</html>
