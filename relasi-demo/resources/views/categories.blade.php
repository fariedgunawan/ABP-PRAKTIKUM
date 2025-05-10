<h1>Categories and Products</h1>

<ul>
@foreach($categories as $category)
    <li>
        <strong>{{ $category->name }}</strong>
        <ul>
            @foreach($category->products as $product)
                <li>{{ $product->name }} - ${{ $product->price }}</li>
            @endforeach
        </ul>
    </li>
@endforeach
</ul>