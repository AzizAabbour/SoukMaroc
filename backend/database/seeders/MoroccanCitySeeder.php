<?php

namespace Database\Seeders;

use App\Models\MoroccanCity;
use Illuminate\Database\Seeder;

class MoroccanCitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name_fr' => 'Casablanca', 'name_ar' => 'الدار البيضاء', 'region_fr' => 'Casablanca-Settat', 'region_ar' => 'الدار البيضاء-سطات'],
            ['name_fr' => 'Rabat', 'name_ar' => 'الرباط', 'region_fr' => 'Rabat-Salé-Kénitra', 'region_ar' => 'الرباط-سلا-القنيطرة'],
            ['name_fr' => 'Salé', 'name_ar' => 'سلا', 'region_fr' => 'Rabat-Salé-Kénitra', 'region_ar' => 'الرباط-سلا-القنيطرة'],
            ['name_fr' => 'Marrakech', 'name_ar' => 'مراكش', 'region_fr' => 'Marrakech-Safi', 'region_ar' => 'مراكش-آسفي'],
            ['name_fr' => 'Fès', 'name_ar' => 'فاس', 'region_fr' => 'Fès-Meknès', 'region_ar' => 'فاس-مكناس'],
            ['name_fr' => 'Tanger', 'name_ar' => 'طنجة', 'region_fr' => 'Tanger-Tétouan-Al Hoceïma', 'region_ar' => 'طنجة-تطوان-الحسيمة'],
            ['name_fr' => 'Agadir', 'name_ar' => 'أكادير', 'region_fr' => 'Souss-Massa', 'region_ar' => 'سوس-ماسة'],
            ['name_fr' => 'Meknès', 'name_ar' => 'مكناس', 'region_fr' => 'Fès-Meknès', 'region_ar' => 'فاس-مكناس'],
            ['name_fr' => 'Oujda', 'name_ar' => 'وجدة', 'region_fr' => 'Oriental', 'region_ar' => 'الشرق'],
            ['name_fr' => 'Kénitra', 'name_ar' => 'القنيطرة', 'region_fr' => 'Rabat-Salé-Kénitra', 'region_ar' => 'الرباط-سلا-القنيطرة'],
            ['name_fr' => 'El Jadida', 'name_ar' => 'الجديدة', 'region_fr' => 'Casablanca-Settat', 'region_ar' => 'الدار البيضاء-سطات'],
            ['name_fr' => 'Mohammedia', 'name_ar' => 'المحمدية', 'region_fr' => 'Casablanca-Settat', 'region_ar' => 'الدار البيضاء-سطات'],
            ['name_fr' => 'Tétouan', 'name_ar' => 'تطوان', 'region_fr' => 'Tanger-Tétouan-Al Hoceïma', 'region_ar' => 'طنجة-تطوان-الحسيمة'],
            ['name_fr' => 'Nador', 'name_ar' => 'الناظور', 'region_fr' => 'Oriental', 'region_ar' => 'الشرق'],
            ['name_fr' => 'Béni Mellal', 'name_ar' => 'بني ملال', 'region_fr' => 'Béni Mellal-Khénifra', 'region_ar' => 'بني ملال-خنيفرة'],
            ['name_fr' => 'Khouribga', 'name_ar' => 'خريبكة', 'region_fr' => 'Béni Mellal-Khénifra', 'region_ar' => 'بني ملال-خنيفرة'],
            ['name_fr' => 'Safi', 'name_ar' => 'آسفي', 'region_fr' => 'Marrakech-Safi', 'region_ar' => 'مراكش-آسفي'],
            ['name_fr' => 'Settat', 'name_ar' => 'سطات', 'region_fr' => 'Casablanca-Settat', 'region_ar' => 'الدار البيضاء-سطات'],
            ['name_fr' => 'Taza', 'name_ar' => 'تازة', 'region_fr' => 'Fès-Meknès', 'region_ar' => 'فاس-مكناس'],
            ['name_fr' => 'Essaouira', 'name_ar' => 'الصويرة', 'region_fr' => 'Marrakech-Safi', 'region_ar' => 'مراكش-آسفي'],
            ['name_fr' => 'Laâyoune', 'name_ar' => 'العيون', 'region_fr' => 'Laâyoune-Sakia El Hamra', 'region_ar' => 'العيون-الساقية الحمراء'],
            ['name_fr' => 'Dakhla', 'name_ar' => 'الداخلة', 'region_fr' => 'Dakhla-Oued Ed-Dahab', 'region_ar' => 'الداخلة-وادي الذهب'],
            ['name_fr' => 'Errachidia', 'name_ar' => 'الراشيدية', 'region_fr' => 'Drâa-Tafilalet', 'region_ar' => 'درعة-تافيلالت'],
            ['name_fr' => 'Ouarzazate', 'name_ar' => 'ورزازات', 'region_fr' => 'Drâa-Tafilalet', 'region_ar' => 'درعة-تافيلالت'],
        ];

        foreach ($cities as $city) {
            MoroccanCity::create($city);
        }
    }
}
