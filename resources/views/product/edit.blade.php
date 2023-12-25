@extends('layout.main')

@section('content')
    <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Daftar Produk</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
            </ol>
        </nav>
    </div>

    <form action="/product/{{ Str::upper($product->id) }}" method="post" enctype="multipart/form-data">

        @csrf
        @method('put')

        <div class="row">
            <div class="col-md-4">
                <label for="category_id" class="form-label">Kategori</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}"
                            {{ old('category_id', $product->category_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-8">
                <label for="name" class="form-label">Nama Barang</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    placeholder="Nama Barang" value="{{ old('name', $product->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label for="purchase_price" class="form-label">Harga Beli</label>
                <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                    name="purchase_price" id="purchase_price" placeholder="Harga Beli"
                    value="{{ old('purchase_price', $product->purchase_price) }}" onkeyup="findSellingPrice(this.value)">
                @error('purchase_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="selling_price" class="form-label">Harga Jual</label>
                <input type="text" class="form-control @error('selling_price') is-invalid @enderror" name="selling_price"
                    id="selling_price" placeholder="Harga Beli"value="{{ old('selling_price', $product->selling_price) }}"
                    readonly>
                @error('selling_price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="stock" class="form-label">Stok Barang</label>
                <input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock"
                    id="stock" placeholder="Stock" value="{{ old('stock', $product->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <input type="hidden" name="oldImage" value="{{ $product->image_path }}">
                <label for="image" class="form-label">Image</label>
                <img id="image-preview" src="{{ asset('storage/' . $product->image_path) }}" class="img-fluid my-2"
                    width="200" style="display: block;" />
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                    id="image" onchange="previewImage()" value="{{ old('image') }}">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <button class="btn btn-md btn-primary float-end mx-2">Simpan</button>
                <a href="/" class="btn btn-md btn-outline-primary float-end">Batalkan</a>
            </div>
        </div>

    </form>

    <script async>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('#image-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();

            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFEvent) {
                imgPreview.src = oFEvent.target.result;
            }
        }

        function findSellingPrice(purchasePrice) {
            if (purchasePrice != '') {
                var percenSellingPrice = Math.round(purchasePrice * 0.3);
                var sellingPrice = parseInt(purchasePrice) + percenSellingPrice;
            } else {
                sellingPrice = '';
            }


            document.querySelector('#selling_price').value = sellingPrice;
        }
    </script>
@endsection
