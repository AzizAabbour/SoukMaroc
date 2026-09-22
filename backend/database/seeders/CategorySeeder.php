<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name_fr' => 'Électronique', 'name_ar' => 'إلكترونيات', 'icon' => '📱', 'sort_order' => 1],
            ['name_fr' => 'Téléphones & Tablettes', 'name_ar' => 'هواتف وأجهزة لوحية', 'icon' => '📲', 'sort_order' => 2],
            ['name_fr' => 'Informatique', 'name_ar' => 'معلوميات', 'icon' => '💻', 'sort_order' => 3],
            ['name_fr' => 'Mode Homme', 'name_ar' => 'أزياء رجالية', 'icon' => '👔', 'sort_order' => 4],
            ['name_fr' => 'Mode Femme', 'name_ar' => 'أزياء نسائية', 'icon' => '👗', 'sort_order' => 5],
            ['name_fr' => 'Maison & Décoration', 'name_ar' => 'المنزل والديكور', 'icon' => '🏠', 'sort_order' => 6],
            ['name_fr' => 'Beauté', 'name_ar' => 'الجمال', 'icon' => '💄', 'sort_order' => 7],
            ['name_fr' => 'Électroménager', 'name_ar' => 'أجهزة منزلية', 'icon' => '🔌', 'sort_order' => 8],
            ['name_fr' => 'Sports', 'name_ar' => 'رياضة', 'icon' => '⚽', 'sort_order' => 9],
            ['name_fr' => 'Automobile', 'name_ar' => 'سيارات', 'icon' => '🚗', 'sort_order' => 10],
            ['name_fr' => 'Bricolage', 'name_ar' => 'أدوات وبريكولاج', 'icon' => '🔧', 'sort_order' => 11],
            ['name_fr' => 'Alimentation', 'name_ar' => 'تغذية', 'icon' => '🍎', 'sort_order' => 12],
            ['name_fr' => 'Artisanat Marocain', 'name_ar' => 'الصناعة التقليدية المغربية', 'icon' => '🏺', 'sort_order' => 13],
            ['name_fr' => 'Produits Traditionnels', 'name_ar' => 'منتجات تقليدية', 'icon' => '🫖', 'sort_order' => 14],
            ['name_fr' => 'Cadeaux', 'name_ar' => 'هدايا', 'icon' => '🎁', 'sort_order' => 15],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name_fr' => $cat['name_fr'],
                'name_ar' => $cat['name_ar'],
                'slug' => Str::slug($cat['name_fr']),
                'icon' => $cat['icon'],
                'sort_order' => $cat['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
