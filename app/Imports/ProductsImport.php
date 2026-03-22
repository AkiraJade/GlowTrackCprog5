<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty($row['name']) || empty($row['price'])) {
                continue;
            }

            Product::create([
                'name' => $row['name'],
                'slug' => Str::slug($row['name']) . '-' . uniqid(),
                'description' => $row['description'] ?? '',
                'brand' => $row['brand'] ?? 'Unknown',
                'classification' => $row['classification'] ?? 'Treatment',
                'price' => $row['price'],
                'size_volume' => $row['size_volume'] ?? '30ml',
                'quantity' => $row['quantity'] ?? 10,
                'low_stock_threshold' => $row['low_stock_threshold'] ?? 5,
                'skin_types' => $this->parseArrayField($row['skin_types'] ?? 'Normal'),
                'active_ingredients' => $this->parseArrayField($row['active_ingredients'] ?? ''),
                'seller_id' => auth()->id(),
                'status' => auth()->user()->isAdmin() ? 'approved' : 'pending',
                'is_verified' => auth()->user()->isAdmin(),
                'expiry_date' => $this->parseDate($row['expiry_date'] ?? null),
                'inventory_notes' => $row['inventory_notes'] ?? '',
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:999999.99',
            'classification' => 'nullable|in:Cleanser,Moisturizer,Serum,Toner,Sunscreen,Mask,Exfoliant,Treatment',
            'quantity' => 'nullable|integer|min:0',
            'skin_types' => 'nullable|string',
            'active_ingredients' => 'nullable|string',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    private function parseArrayField($value): array
    {
        if (empty($value)) {
            return [];
        }

        // Handle comma-separated values
        if (is_string($value)) {
            return array_map('trim', explode(',', $value));
        }

        return (array) $value;
    }

    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
