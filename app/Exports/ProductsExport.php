<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $products;

    public function __construct($products = null)
    {
        $this->products = $products ?: Product::with('seller')->get();
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Brand',
            'Classification',
            'Price',
            'Size/Volume',
            'Quantity',
            'Low Stock Threshold',
            'Skin Types',
            'Active Ingredients',
            'Seller Name',
            'Status',
            'Is Verified',
            'Average Rating',
            'Review Count',
            'Expiry Date',
            'Inventory Notes',
            'Created At',
            'Updated At',
        ];
    }

    public function map($product): array
    {
        // Handle both arrays and objects
        $id = is_array($product) ? ($product['id'] ?? '') : $product->id;
        $name = is_array($product) ? ($product['name'] ?? '') : $product->name;
        $description = is_array($product) ? ($product['description'] ?? '') : $product->description;
        $brand = is_array($product) ? ($product['brand'] ?? '') : $product->brand;
        $classification = is_array($product) ? ($product['classification'] ?? '') : $product->classification;
        $price = is_array($product) ? ($product['price'] ?? 0) : $product->price;
        $size_volume = is_array($product) ? ($product['size_volume'] ?? '') : $product->size_volume;
        $quantity = is_array($product) ? ($product['quantity'] ?? 0) : $product->quantity;
        $low_stock_threshold = is_array($product) ? ($product['low_stock_threshold'] ?? 0) : $product->low_stock_threshold;
        $skin_types = is_array($product) ? ($product['skin_types'] ?? '') : ($product->skin_types ?? '');
        $active_ingredients = is_array($product) ? ($product['active_ingredients'] ?? '') : ($product->active_ingredients ?? '');
        $seller_name = is_array($product) ? ($product['seller'] ?? 'Unknown') : ($product->seller->name ?? 'Unknown');
        $status = is_array($product) ? ($product['status'] ?? 'pending') : $product->status;
        $is_verified = is_array($product) ? ($product['is_verified'] ?? false) : $product->is_verified;
        $average_rating = is_array($product) ? ($product['average_rating'] ?? 0) : $product->average_rating;
        $created_at = is_array($product) ? ($product['created_at'] ?? now()) : $product->created_at;
        $updated_at = is_array($product) ? ($product['updated_at'] ?? now()) : $product->updated_at;

        return [
            $id,
            $name,
            $description,
            $brand,
            $classification,
            $price,
            $size_volume,
            $quantity,
            $low_stock_threshold,
            is_string($skin_types) ? $skin_types : implode(', ', $skin_types ?? []),
            is_string($active_ingredients) ? $active_ingredients : implode(', ', $active_ingredients ?? []),
            $seller_name,
            $status,
            $is_verified ? 'Yes' : 'No',
            $average_rating,
            $created_at,
            $updated_at,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:S1' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2EFDA']]],
        ];
    }
}
