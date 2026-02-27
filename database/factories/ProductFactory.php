<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classifications = ['Cleanser', 'Moisturizer', 'Serum', 'Toner', 'Sunscreen', 'Mask', 'Exfoliant', 'Treatment'];
        $skinTypes = ['Oily', 'Dry', 'Combination', 'Sensitive', 'Normal'];
        $ingredients = [
            'Niacinamide', 'Retinol', 'Hyaluronic Acid', 'Vitamin C', 'Salicylic Acid',
            'Glycolic Acid', 'Ceramides', 'Peptides', 'Azelaic Acid', 'Bakuchiol',
            'Vitamin E', 'Aloe Vera', 'Green Tea Extract', 'Tea Tree Oil', 'Zinc Oxide'
        ];
        
        $brands = ['GlowLab', 'SkinPure', 'DermEssence', 'BeautyPro', 'ClearSkin', 'RadiantCare'];
        
        return [
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->text(200),
            'brand' => $this->faker->randomElement($brands),
            'classification' => $this->faker->randomElement($classifications),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'size_volume' => $this->faker->randomElement(['30ml', '50ml', '100ml', '150ml', '200ml', '250ml']),
            'quantity' => $this->faker->numberBetween(0, 100),
            'skin_types' => $this->faker->randomElements($skinTypes, $this->faker->numberBetween(1, 3)),
            'active_ingredients' => $this->faker->randomElements($ingredients, $this->faker->numberBetween(2, 5)),
            'photo' => 'product-' . $this->faker->numberBetween(1, 10) . '.jpg',
            'seller_id' => User::where('role', 'seller')->inRandomOrder()->first()->id ?? User::factory()->seller()->create()->id,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'inactive']),
            'is_verified' => $this->faker->boolean(70), // 70% chance of being verified
            'average_rating' => $this->faker->randomFloat(2, 1, 5),
            'review_count' => $this->faker->numberBetween(0, 500),
        ];
    }

    /**
     * Create an approved product.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Create a verified product.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_verified' => true,
        ]);
    }

    /**
     * Create an in-stock product.
     */
    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(10, 100),
        ]);
    }

    /**
     * Create a low stock product.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => $this->faker->numberBetween(1, 5),
        ]);
    }

    /**
     * Create an out of stock product.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }
}
