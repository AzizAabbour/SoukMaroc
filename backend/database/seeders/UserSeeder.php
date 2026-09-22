<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin SoukMaroc',
            'email' => 'admin@soukmaroc.ma',
            'password' => Hash::make('password'),
            'phone' => '+212600000000',
            'role' => 'admin',
            'city' => 'Casablanca',
            'region' => 'Casablanca-Settat',
            'email_verified_at' => now(),
        ]);

        // Seller users
        $sellers = [
            ['name' => 'Ahmed Benali', 'email' => 'ahmed@soukmaroc.ma', 'city' => 'Marrakech', 'store' => 'Artisanat du Maroc', 'desc_fr' => 'Spécialiste en artisanat marocain traditionnel. Produits faits main de qualité supérieure.', 'desc_ar' => 'متخصص في الصناعة التقليدية المغربية. منتجات يدوية عالية الجودة.'],
            ['name' => 'Fatima Zahra El Amrani', 'email' => 'fatima@soukmaroc.ma', 'city' => 'Fès', 'store' => 'Fès Tradition', 'desc_fr' => 'Boutique de produits traditionnels de Fès. Céramique, textile et décoration.', 'desc_ar' => 'متجر المنتجات التقليدية الفاسية. خزف ونسيج وديكور.'],
            ['name' => 'Youssef Alaoui', 'email' => 'youssef@soukmaroc.ma', 'city' => 'Casablanca', 'store' => 'TechMaroc', 'desc_fr' => 'Votre partenaire technologique au Maroc. Smartphones, ordinateurs et accessoires.', 'desc_ar' => 'شريككم التكنولوجي في المغرب. هواتف ذكية وحواسيب وإكسسوارات.'],
            ['name' => 'Khadija Bennani', 'email' => 'khadija@soukmaroc.ma', 'city' => 'Rabat', 'store' => 'Mode & Beauté', 'desc_fr' => 'Mode et beauté pour la femme marocaine moderne. Caftans, cosmétiques et accessoires.', 'desc_ar' => 'أزياء وجمال للمرأة المغربية العصرية. قفاطين ومستحضرات تجميل وإكسسوارات.'],
            ['name' => 'Omar Tazi', 'email' => 'omar@soukmaroc.ma', 'city' => 'Tanger', 'store' => 'Maison du Nord', 'desc_fr' => 'Décoration et ameublement inspirés du nord du Maroc. Qualité et authenticité.', 'desc_ar' => 'ديكور وأثاث مستوحى من شمال المغرب. جودة وأصالة.'],
        ];

        foreach ($sellers as $s) {
            $user = User::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'phone' => '+2126' . rand(10000000, 99999999),
                'role' => 'seller',
                'city' => $s['city'],
                'email_verified_at' => now(),
            ]);

            Seller::create([
                'user_id' => $user->id,
                'store_name' => $s['store'],
                'slug' => Str::slug($s['store']),
                'description_fr' => $s['desc_fr'],
                'description_ar' => $s['desc_ar'],
                'phone' => $user->phone,
                'city' => $s['city'],
                'is_verified' => true,
                'rating' => rand(35, 50) / 10,
                'total_sales' => rand(50, 500),
            ]);
        }

        // Regular customers
        $customers = [
            ['name' => 'Mohammed Idrissi', 'city' => 'Casablanca'],
            ['name' => 'Amina Berrada', 'city' => 'Rabat'],
            ['name' => 'Hassan Chraibi', 'city' => 'Marrakech'],
            ['name' => 'Salma Kettani', 'city' => 'Fès'],
            ['name' => 'Rachid Fassi Fihri', 'city' => 'Meknès'],
            ['name' => 'Nadia Squalli', 'city' => 'Tanger'],
            ['name' => 'Karim Benhima', 'city' => 'Agadir'],
            ['name' => 'Laila Tounsi', 'city' => 'Oujda'],
            ['name' => 'Mehdi Andaloussi', 'city' => 'Kénitra'],
            ['name' => 'Zineb Filali', 'city' => 'El Jadida'],
            ['name' => 'Anas Benjelloun', 'city' => 'Mohammedia'],
            ['name' => 'Sara Ouazzani', 'city' => 'Tétouan'],
            ['name' => 'Driss Lahlou', 'city' => 'Safi'],
            ['name' => 'Houda Cherkaoui', 'city' => 'Béni Mellal'],
            ['name' => 'Yassine El Mansouri', 'city' => 'Settat'],
            ['name' => 'Imane Rachidi', 'city' => 'Nador'],
            ['name' => 'Bilal Hajji', 'city' => 'Essaouira'],
            ['name' => 'Ghita Fassi', 'city' => 'Casablanca'],
            ['name' => 'Tariq Benkirane', 'city' => 'Rabat'],
            ['name' => 'Meryem Alami', 'city' => 'Marrakech'],
        ];

        foreach ($customers as $c) {
            User::create([
                'name' => $c['name'],
                'email' => Str::slug($c['name'], '.') . '@email.com',
                'password' => Hash::make('password'),
                'phone' => '+2126' . rand(10000000, 99999999),
                'role' => 'customer',
                'city' => $c['city'],
                'email_verified_at' => now(),
            ]);
        }
    }
}
