<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IngredientConflict;

class IngredientConflictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conflicts = [
            // Retinol conflicts (severe)
            [
                'ingredient_1' => 'retinol',
                'ingredient_2' => 'aha',
                'severity' => 'severe',
                'description' => 'Retinol and AHAs (Alpha Hydroxy Acids) should not be used together as they can cause severe irritation, redness, and compromise the skin barrier. Both are strong exfoliants that can over-exfoliate the skin when combined.',
                'recommendation' => 'Use retinol in your PM routine and AHAs in your AM routine on separate days, or alternate days. Always use sunscreen when using these ingredients.',
                'alternatives' => ['bakuchiol', 'peptides', 'niacinamide', 'hyaluronic acid'],
            ],
            [
                'ingredient_1' => 'retinol',
                'ingredient_2' => 'bha',
                'severity' => 'severe',
                'description' => 'Retinol and BHAs (Beta Hydroxy Acids like salicylic acid) can cause excessive irritation and dryness when used together. Both ingredients increase skin cell turnover and can damage the skin barrier.',
                'recommendation' => 'Separate usage by at least 12 hours or use on alternate days. Consider using retinol at night and BHA in the morning on different days.',
                'alternatives' => ['bakuchiol', 'green tea extract', 'niacinamide', 'zinc'],
            ],
            [
                'ingredient_1' => 'retinol',
                'ingredient_2' => 'vitamin c',
                'severity' => 'high',
                'description' => 'Retinol and Vitamin C can neutralize each other\'s effectiveness when applied at the same time. Both work optimally at different pH levels and can cause irritation when combined.',
                'recommendation' => 'Use Vitamin C in your AM routine and retinol in your PM routine on separate days, or alternate morning/evening usage.',
                'alternatives' => ['ferulic acid', 'vitamin e', 'niacinamide', 'bakuchiol'],
            ],

            // Vitamin C conflicts
            [
                'ingredient_1' => 'vitamin c',
                'ingredient_2' => 'niacinamide',
                'severity' => 'moderate',
                'description' => 'Vitamin C and niacinamide can potentially form a complex that reduces their effectiveness, though this is more likely at high concentrations and low pH levels.',
                'recommendation' => 'Use at different times of day or wait 10-15 minutes between applications. Most modern formulations are stable together.',
                'alternatives' => ['vitamin e', 'ferulic acid', 'hyaluronic acid', 'peptides'],
            ],

            // AHA/BHA conflicts
            [
                'ingredient_1' => 'aha',
                'ingredient_2' => 'bha',
                'severity' => 'high',
                'description' => 'Using AHAs and BHAs together can cause excessive exfoliation, leading to irritation, redness, and compromised skin barrier. Both are chemical exfoliants that work similarly.',
                'recommendation' => 'Choose one exfoliant per routine and alternate days. If using both, use one in AM and one in PM on different days.',
                'alternatives' => ['enzymatic exfoliants', 'gentle physical scrubs', 'rice powder', 'lactic acid only'],
            ],

            // Benzoyl Peroxide conflicts
            [
                'ingredient_1' => 'benzoyl peroxide',
                'ingredient_2' => 'retinol',
                'severity' => 'high',
                'description' => 'Benzoyl peroxide and retinol can cause severe irritation and dryness. Benzoyl peroxide can also degrade retinol, making it less effective.',
                'recommendation' => 'Use at different times of day or on alternate days. Apply benzoyl peroxide in the morning and retinol at night.',
                'alternatives' => ['salicylic acid', 'azelaic acid', 'sulfur', 'tea tree oil'],
            ],

            // Copper peptide conflicts
            [
                'ingredient_1' => 'copper peptide',
                'ingredient_2' => 'vitamin c',
                'severity' => 'moderate',
                'description' => 'Copper peptides and Vitamin C can oxidize each other, reducing their effectiveness. Both are antioxidants that can interfere with each other\'s action.',
                'recommendation' => 'Use at different times of day - Vitamin C in morning, copper peptides in evening, or alternate days.',
                'alternatives' => ['peptides', 'growth factors', 'niacinamide', 'hyaluronic acid'],
            ],

            // Salicylic acid conflicts
            [
                'ingredient_1' => 'salicylic acid',
                'ingredient_2' => 'niacinamide',
                'severity' => 'low',
                'description' => 'Salicylic acid and niacinamide are generally compatible, but in some cases, niacinamide can reduce the effectiveness of salicylic acid, particularly at high concentrations.',
                'recommendation' => 'Usually safe to use together, but if concerned, use at different times or monitor skin response.',
                'alternatives' => ['zinc', 'green tea', 'clay masks', 'sulfur'],
            ],

            // Hydroquinone conflicts
            [
                'ingredient_1' => 'hydroquinone',
                'ingredient_2' => 'benzoyl peroxide',
                'severity' => 'severe',
                'description' => 'Hydroquinone and benzoyl peroxide can cause severe skin staining and irritation. Benzoyl peroxide can oxidize hydroquinone, making it less effective and potentially causing permanent skin discoloration.',
                'recommendation' => 'Never use together. Use at different times of day on completely separate days, with thorough cleansing between applications.',
                'alternatives' => ['azelaic acid', 'kojic acid', 'arbutin', 'vitamin c'],
            ],

            // Additional common conflicts
            [
                'ingredient_1' => 'glycolic acid',
                'ingredient_2' => 'lactic acid',
                'severity' => 'moderate',
                'description' => 'Using multiple AHAs like glycolic acid and lactic acid together can cause over-exfoliation and irritation, as they work similarly to exfoliate the skin.',
                'recommendation' => 'Choose one AHA per routine and alternate days. Both are effective exfoliants, so using both is redundant.',
                'alternatives' => ['mandelic acid', 'azelaic acid', 'enzymatic exfoliants'],
            ],

            [
                'ingredient_1' => 'vitamin c',
                'ingredient_2' => 'aha',
                'severity' => 'moderate',
                'description' => 'Vitamin C and AHAs can both be effective but may cause irritation when used together, especially if the Vitamin C formulation has a low pH.',
                'recommendation' => 'Use at different times of day or alternate days. Apply Vitamin C in morning and AHA in evening on separate days.',
                'alternatives' => ['ferulic acid', 'vitamin e', 'niacinamide', 'bakuchiol'],
            ],

            [
                'ingredient_1' => 'retinol',
                'ingredient_2' => 'azelaic acid',
                'severity' => 'low',
                'description' => 'Retinol and azelaic acid are generally compatible and can actually work well together for acne and hyperpigmentation, but may cause initial irritation.',
                'recommendation' => 'Usually safe to use together, but introduce slowly and monitor for irritation. Use azelaic acid in morning, retinol at night.',
                'alternatives' => ['niacinamide', 'salicylic acid', 'bakuchiol'],
            ],

            [
                'ingredient_1' => 'niacinamide',
                'ingredient_2' => 'aha',
                'severity' => 'low',
                'description' => 'Niacinamide and AHAs are generally compatible, but some formulations may cause temporary redness or flushing when first used together.',
                'recommendation' => 'Usually safe to use together. Apply niacinamide first, wait 10-15 minutes, then apply AHA.',
                'alternatives' => ['vitamin c', 'peptides', 'ceramides'],
            ],
        ];

        foreach ($conflicts as $conflict) {
            IngredientConflict::create(array_merge($conflict, [
                'is_active' => true,
            ]));
        }

        $this->command->info('Ingredient conflicts seeded successfully!');
    }
}
