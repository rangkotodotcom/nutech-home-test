@extends('layout.main')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Daftar Produk</h2>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-8">
                    <form action="/" method="get">
                        <div class="input-group mb-3">
                            @if (request()->category)
                                <input type="hidden" name="category" value="{{ request()->category }}">
                            @endif
                            <input type="text" class="form-control" name="search" placeholder="Cari Barang"
                                value="{{ request()->search }}" aria-describedby="button-addon2">
                            <button type="submit" class="btn btn-outline-success" type="button"
                                id="button-addon2">Cari</button>
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    <select name="category_id" id="category_id" class="form-select" onchange="searchByCategory(this.value)">
                        <option value="">Semua</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ request()->category == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-6 mr-0 ml-auto d-block">
            <form action="/product/export" class="d-inline" method="post">
                @csrf
                <button class="btn btn-sm btn-success float-end">Export Excel</button>
            </form>
            <a href="/product/create" class="btn btn-sm btn-danger mx-2 float-end">Tambah Produk</a>
        </div>
    </div>

    <br>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Image</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Kategori Produk</th>
                    <th scope="col">Harga Beli (Rp)</th>
                    <th scope="col">Harga Jual (Rp)</th>
                    <th scope="col">Stok Produk</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $item)
                    <tr>
                        <td>
                            {{ ($product->currentPage() - 1) * $product->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="" class="img-thumbnail"
                                width="100">
                        </td>
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            {{ $item->category->name }}
                        </td>
                        <td>
                            Rp {{ number_format($item->purchase_price) }}
                        </td>
                        <td>
                            Rp {{ number_format($item->selling_price) }}
                        </td>
                        <td>
                            {{ $item->stock }}
                        </td>
                        <td>
                            <a href="/product/{{ Str::upper($item->id) }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/product/{{ Str::upper($item->id) }}" method="post"
                                class="d-inline form{{ $loop->iteration }}">
                                @csrf
                                @method('delete')

                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('form{{ $loop->iteration }}')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="justify-content-end">
            {{ $product->links() }}
        </div>
    </div>

    <script async>
        function confirmDelete(nameForm) {
            return confirm('Yakin ingin menghapus produk ini?') ? document.getElementsByClassName(nameForm)[0].submit() :
                false;
        }

        function searchByCategory(categoryId) {
            categoryId = categoryId;
            window.location.href = categoryId != '' ? "/?category=" + categoryId : '/';
        }
    </script>
@endsection
