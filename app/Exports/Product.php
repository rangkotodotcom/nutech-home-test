<?php

namespace App\Exports;

use App\Models\Product as ProductModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class Product implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        $heading = [
            'No',
            'Nama Produk',
            'Kategori Produk',
            'Harga Barang',
            'Harga Jual',
            'Stok',
        ];

        return $heading;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $product = ProductModel::latest()->filter(request(['search', 'category']))->get()->toArray();

        return collect(array_map(fn ($index, $value) => [
            $index + 1,
            $value['name'],
            $value['category']['name'],
            number_format($value['purchase_price']),
            number_format($value['selling_price']),
            $value['stock'],
        ], array_keys($product), $product));
    }
}
