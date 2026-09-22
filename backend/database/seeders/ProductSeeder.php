<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Seller;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = Seller::all();
        $categories = Category::all()->keyBy('slug');

        $products = [
            // Artisanat Marocain (seller 1 - Artisanat du Maroc)
            [
                'seller_idx' => 0, 'category' => 'artisanat-marocain',
                'name_fr' => 'Tajine Traditionnel en Terre Cuite', 'name_ar' => 'طاجين تقليدي من الفخار',
                'desc_fr' => 'Tajine marocain authentique fabriqué à la main en terre cuite naturelle. Idéal pour la cuisson lente des plats traditionnels marocains. Chaque pièce est unique et porte la marque du savoir-faire artisanal marocain.',
                'desc_ar' => 'طاجين مغربي أصيل مصنوع يدوياً من الفخار الطبيعي. مثالي للطهي البطيء للأطباق التقليدية المغربية.',
                'short_fr' => 'Tajine authentique fait main, cuisson traditionnelle',
                'price' => 189.00, 'old_price' => 249.00, 'stock' => 45, 'featured' => true,
                'variants' => [['type' => 'size', 'name' => 'Taille', 'value' => 'Moyen', 'stock' => 25], ['type' => 'size', 'name' => 'Taille', 'value' => 'Grand', 'stock' => 20, 'adj' => 50]],
            ],
            [
                'seller_idx' => 0, 'category' => 'artisanat-marocain',
                'name_fr' => 'Théière Marocaine en Inox Gravé', 'name_ar' => 'إبريق شاي مغربي من الفولاذ المنقوش',
                'desc_fr' => 'Magnifique théière marocaine en acier inoxydable avec gravures traditionnelles. Parfaite pour préparer le thé à la menthe marocain authentique.',
                'desc_ar' => 'إبريق شاي مغربي رائع من الفولاذ المقاوم للصدأ مع نقوش تقليدية.',
                'short_fr' => 'Théière inox gravée, style traditionnel marocain',
                'price' => 149.00, 'old_price' => 199.00, 'stock' => 60, 'featured' => true,
            ],
            [
                'seller_idx' => 0, 'category' => 'artisanat-marocain',
                'name_fr' => 'Lampe Marocaine en Laiton Ajouré', 'name_ar' => 'مصباح مغربي من النحاس المخرم',
                'desc_fr' => 'Lampe traditionnelle marocaine en laiton finement ajouré. Crée une ambiance chaleureuse avec ses jeux de lumière caractéristiques.',
                'desc_ar' => 'مصباح تقليدي مغربي من النحاس المخرم بدقة. يخلق أجواء دافئة بألعاب الضوء المميزة.',
                'short_fr' => 'Lampe laiton ajouré, ambiance orientale',
                'price' => 349.00, 'old_price' => 450.00, 'stock' => 25, 'featured' => true,
            ],
            [
                'seller_idx' => 0, 'category' => 'maison-decoration',
                'name_fr' => 'Tapis Berbère Fait Main', 'name_ar' => 'زربية أمازيغية مصنوعة يدوياً',
                'desc_fr' => 'Authentique tapis berbère tissé à la main par des artisanes marocaines. Motifs géométriques traditionnels, laine naturelle de qualité supérieure.',
                'desc_ar' => 'زربية أمازيغية أصيلة منسوجة يدوياً. أنماط هندسية تقليدية، صوف طبيعي عالي الجودة.',
                'short_fr' => 'Tapis berbère authentique en laine naturelle',
                'price' => 1299.00, 'old_price' => 1800.00, 'stock' => 12, 'featured' => true,
            ],
            [
                'seller_idx' => 0, 'category' => 'artisanat-marocain',
                'name_fr' => 'Service à Thé Marocain Complet', 'name_ar' => 'طقم شاي مغربي كامل',
                'desc_fr' => 'Service à thé marocain complet comprenant une théière, 6 verres décorés, et un plateau en métal ciselé. L\'art du thé marocain dans toute sa splendeur.',
                'desc_ar' => 'طقم شاي مغربي كامل يشمل إبريقاً و6 كؤوس مزخرفة وصينية معدنية منقوشة.',
                'short_fr' => 'Set complet: théière + 6 verres + plateau',
                'price' => 399.00, 'old_price' => 550.00, 'stock' => 30, 'featured' => true,
            ],

            // Fès Tradition (seller 2)
            [
                'seller_idx' => 1, 'category' => 'produits-traditionnels',
                'name_fr' => 'Huile d\'Argan Bio Pure', 'name_ar' => 'زيت أركان عضوي نقي',
                'desc_fr' => 'Huile d\'argan 100% bio et pure, pressée à froid. Extraite des noix d\'arganier du sud du Maroc. Usage cosmétique et culinaire.',
                'desc_ar' => 'زيت أركان عضوي 100% ونقي، معصور على البارد. مستخلص من ثمار شجرة الأركان بجنوب المغرب.',
                'short_fr' => 'Huile d\'argan 100% bio, pressée à froid',
                'price' => 129.00, 'old_price' => 169.00, 'stock' => 80, 'featured' => true,
            ],
            [
                'seller_idx' => 1, 'category' => 'produits-traditionnels',
                'name_fr' => 'Coffret Épices Marocaines Premium', 'name_ar' => 'علبة توابل مغربية فاخرة',
                'desc_fr' => 'Coffret de 12 épices marocaines authentiques: Ras el Hanout, cumin, safran, cannelle, gingembre, paprika et plus. Idéal pour la cuisine marocaine.',
                'desc_ar' => 'علبة 12 نوعاً من التوابل المغربية الأصيلة: رأس الحانوت، كمون، زعفران، قرفة، زنجبيل وغيرها.',
                'short_fr' => 'Coffret 12 épices: Ras el Hanout, safran, cumin...',
                'price' => 199.00, 'old_price' => null, 'stock' => 100, 'featured' => false,
            ],
            [
                'seller_idx' => 1, 'category' => 'artisanat-marocain',
                'name_fr' => 'Céramique de Fès - Assiette Décorative', 'name_ar' => 'خزف فاسي - طبق ديكور',
                'desc_fr' => 'Assiette décorative en céramique peinte à la main dans la tradition de Fès. Motifs bleus et blancs caractéristiques de l\'artisanat fassi.',
                'desc_ar' => 'طبق ديكور من الخزف المرسوم يدوياً على الطريقة الفاسية التقليدية.',
                'short_fr' => 'Assiette céramique de Fès, peinte à la main',
                'price' => 249.00, 'old_price' => 320.00, 'stock' => 35, 'featured' => false,
            ],
            [
                'seller_idx' => 1, 'category' => 'produits-traditionnels',
                'name_fr' => 'Safran Marocain de Taliouine', 'name_ar' => 'زعفران مغربي من تالوين',
                'desc_fr' => 'Safran pur de Taliouine, la capitale mondiale du safran. Qualité premium, arôme intense et couleur dorée.',
                'desc_ar' => 'زعفران نقي من تالوين، عاصمة الزعفران العالمية. جودة فائقة ورائحة مكثفة.',
                'short_fr' => 'Safran pur de Taliouine, qualité premium',
                'price' => 89.00, 'old_price' => null, 'stock' => 200, 'featured' => true,
            ],
            [
                'seller_idx' => 1, 'category' => 'beaute',
                'name_fr' => 'Savon Noir Beldi Naturel', 'name_ar' => 'صابون بلدي أسود طبيعي',
                'desc_fr' => 'Savon noir beldi 100% naturel à base d\'huile d\'olive. Exfoliant traditionnel du hammam marocain. Peau douce et purifiée.',
                'desc_ar' => 'صابون بلدي أسود طبيعي 100% من زيت الزيتون. مقشر تقليدي للحمام المغربي.',
                'short_fr' => 'Savon noir à l\'huile d\'olive, hammam traditionnel',
                'price' => 49.00, 'old_price' => 69.00, 'stock' => 150, 'featured' => false,
            ],

            // TechMaroc (seller 3)
            [
                'seller_idx' => 2, 'category' => 'telephones-tablettes',
                'name_fr' => 'Samsung Galaxy A54 5G', 'name_ar' => 'سامسونج جالاكسي A54 5G',
                'desc_fr' => 'Smartphone Samsung Galaxy A54 5G avec écran Super AMOLED 6.4", processeur Exynos 1380, 8Go RAM, 128Go stockage. Triple caméra 50MP.',
                'desc_ar' => 'هاتف سامسونج جالاكسي A54 5G بشاشة Super AMOLED 6.4 بوصة، معالج Exynos 1380.',
                'short_fr' => 'Galaxy A54 5G - 8Go/128Go - Triple caméra 50MP',
                'price' => 3499.00, 'old_price' => 4299.00, 'stock' => 35, 'featured' => true, 'brand' => 'samsung',
                'variants' => [['type' => 'color', 'name' => 'Couleur', 'value' => 'Noir', 'stock' => 15], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Blanc', 'stock' => 10], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Violet', 'stock' => 10]],
            ],
            [
                'seller_idx' => 2, 'category' => 'telephones-tablettes',
                'name_fr' => 'Xiaomi Redmi Note 13 Pro', 'name_ar' => 'شاومي ريدمي نوت 13 برو',
                'desc_fr' => 'Xiaomi Redmi Note 13 Pro avec caméra 200MP, écran AMOLED 120Hz, charge rapide 67W, 8Go RAM, 256Go stockage.',
                'desc_ar' => 'شاومي ريدمي نوت 13 برو بكاميرا 200 ميجابكسل وشاشة AMOLED بمعدل تحديث 120Hz.',
                'short_fr' => 'Redmi Note 13 Pro - 200MP - 8Go/256Go',
                'price' => 2799.00, 'old_price' => 3299.00, 'stock' => 50, 'featured' => true, 'brand' => 'xiaomi',
            ],
            [
                'seller_idx' => 2, 'category' => 'informatique',
                'name_fr' => 'HP Laptop 15s - Intel Core i5', 'name_ar' => 'حاسوب HP Laptop 15s - إنتل كور i5',
                'desc_fr' => 'Ordinateur portable HP 15.6" Full HD, Intel Core i5-1235U, 8Go RAM DDR4, SSD 512Go, Windows 11. Idéal pour le travail et les études.',
                'desc_ar' => 'حاسوب محمول HP بشاشة 15.6 بوصة Full HD، معالج Intel Core i5-1235U.',
                'short_fr' => 'HP 15.6" i5-1235U, 8Go RAM, SSD 512Go',
                'price' => 5999.00, 'old_price' => 7499.00, 'stock' => 20, 'featured' => true, 'brand' => 'hp',
            ],
            [
                'seller_idx' => 2, 'category' => 'electronique',
                'name_fr' => 'Écouteurs Bluetooth Sans Fil Pro', 'name_ar' => 'سماعات بلوتوث لاسلكية برو',
                'desc_fr' => 'Écouteurs sans fil avec réduction de bruit active, autonomie 30h, résistance à l\'eau IPX5. Son Hi-Fi immersif.',
                'desc_ar' => 'سماعات لاسلكية مع تقنية إلغاء الضوضاء النشطة، بطارية 30 ساعة.',
                'short_fr' => 'Écouteurs ANC, 30h autonomie, IPX5',
                'price' => 349.00, 'old_price' => 499.00, 'stock' => 80, 'featured' => false,
            ],
            [
                'seller_idx' => 2, 'category' => 'electronique',
                'name_fr' => 'Smart TV 55" 4K Ultra HD', 'name_ar' => 'تلفاز ذكي 55 بوصة 4K',
                'desc_fr' => 'Téléviseur intelligent 55 pouces 4K UHD avec HDR10, Smart TV Android, WiFi intégré. Expérience cinématographique à domicile.',
                'desc_ar' => 'تلفاز ذكي 55 بوصة بدقة 4K UHD مع HDR10 ونظام أندرويد.',
                'short_fr' => 'TV 55" 4K HDR10, Android Smart TV',
                'price' => 4499.00, 'old_price' => 5999.00, 'stock' => 15, 'featured' => true,
            ],
            [
                'seller_idx' => 2, 'category' => 'informatique',
                'name_fr' => 'Souris Gaming RGB Sans Fil', 'name_ar' => 'فأرة ألعاب RGB لاسلكية',
                'desc_fr' => 'Souris gaming sans fil avec capteur optique 16000 DPI, éclairage RGB personnalisable, 7 boutons programmables.',
                'desc_ar' => 'فأرة ألعاب لاسلكية بمستشعر بصري 16000 DPI وإضاءة RGB قابلة للتخصيص.',
                'short_fr' => 'Souris gaming 16000 DPI, RGB, sans fil',
                'price' => 249.00, 'old_price' => 349.00, 'stock' => 100, 'featured' => false,
            ],

            // Mode & Beauté (seller 4)
            [
                'seller_idx' => 3, 'category' => 'mode-femme',
                'name_fr' => 'Caftan Marocain Haute Couture', 'name_ar' => 'قفطان مغربي أنيق',
                'desc_fr' => 'Caftan marocain de haute couture, confectionné avec des tissus nobles et des broderies dorées faites main. Idéal pour les mariages et cérémonies.',
                'desc_ar' => 'قفطان مغربي فاخر، مصنوع من أقمشة نبيلة وتطريز ذهبي يدوي. مثالي للأعراس والمناسبات.',
                'short_fr' => 'Caftan haute couture, broderies dorées',
                'price' => 2499.00, 'old_price' => 3500.00, 'stock' => 8, 'featured' => true,
                'variants' => [['type' => 'size', 'name' => 'Taille', 'value' => 'S', 'stock' => 2], ['type' => 'size', 'name' => 'Taille', 'value' => 'M', 'stock' => 3], ['type' => 'size', 'name' => 'Taille', 'value' => 'L', 'stock' => 3]],
            ],
            [
                'seller_idx' => 3, 'category' => 'mode-homme',
                'name_fr' => 'Djellaba Marocaine Homme Premium', 'name_ar' => 'جلابة مغربية رجالية فاخرة',
                'desc_fr' => 'Djellaba traditionnelle marocaine pour homme, tissu de qualité supérieure, broderies Sfifa et Aâkad. Confort et élégance.',
                'desc_ar' => 'جلابة تقليدية مغربية للرجال، قماش عالي الجودة، تطريز السفيفة والعقاد.',
                'short_fr' => 'Djellaba brodée Sfifa, tissu premium',
                'price' => 599.00, 'old_price' => 799.00, 'stock' => 30, 'featured' => true,
                'variants' => [['type' => 'color', 'name' => 'Couleur', 'value' => 'Blanc', 'stock' => 10], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Bleu marine', 'stock' => 10], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Gris', 'stock' => 10]],
            ],
            [
                'seller_idx' => 3, 'category' => 'mode-femme',
                'name_fr' => 'Babouches Marocaines Femme Cuir', 'name_ar' => 'بلغة مغربية نسائية من الجلد',
                'desc_fr' => 'Babouches marocaines en cuir véritable, fabriquées à la main. Design traditionnel avec finitions modernes. Confortables et élégantes.',
                'desc_ar' => 'بلغة مغربية من الجلد الطبيعي، مصنوعة يدوياً. تصميم تقليدي بلمسات عصرية.',
                'short_fr' => 'Babouches cuir véritable, fait main',
                'price' => 179.00, 'old_price' => 249.00, 'stock' => 50, 'featured' => true,
                'variants' => [['type' => 'color', 'name' => 'Couleur', 'value' => 'Rouge', 'stock' => 15], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Or', 'stock' => 15], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Noir', 'stock' => 20]],
            ],
            [
                'seller_idx' => 3, 'category' => 'beaute',
                'name_fr' => 'Coffret Beauté Marocaine', 'name_ar' => 'علبة جمال مغربية',
                'desc_fr' => 'Coffret complet de beauté marocaine: huile d\'argan, eau de rose, ghassoul, savon noir. Rituel hammam traditionnel.',
                'desc_ar' => 'علبة جمال مغربية كاملة: زيت أركان، ماء الورد، الغاسول، الصابون الأسود.',
                'short_fr' => 'Coffret hammam: argan, rose, ghassoul, savon noir',
                'price' => 299.00, 'old_price' => 399.00, 'stock' => 40, 'featured' => false,
            ],

            // Maison du Nord (seller 5)
            [
                'seller_idx' => 4, 'category' => 'maison-decoration',
                'name_fr' => 'Pouf Marocain en Cuir Véritable', 'name_ar' => 'بوف مغربي من الجلد الطبيعي',
                'desc_fr' => 'Pouf marocain en cuir véritable tanné à la main. Motifs gravés traditionnels. Rembourreur non inclus pour faciliter l\'expédition.',
                'desc_ar' => 'بوف مغربي من الجلد الطبيعي المدبوغ يدوياً. نقوش تقليدية محفورة.',
                'short_fr' => 'Pouf cuir gravé, artisanat marocain',
                'price' => 449.00, 'old_price' => 599.00, 'stock' => 20, 'featured' => true,
                'variants' => [['type' => 'color', 'name' => 'Couleur', 'value' => 'Naturel', 'stock' => 8], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Marron', 'stock' => 7], ['type' => 'color', 'name' => 'Couleur', 'value' => 'Noir', 'stock' => 5]],
            ],
            [
                'seller_idx' => 4, 'category' => 'maison-decoration',
                'name_fr' => 'Miroir Mural Marocain Zellige', 'name_ar' => 'مرآة حائط مغربية بالزليج',
                'desc_fr' => 'Miroir mural décoratif encadré de mosaïque zellige authentique. Pièce artisanale unique inspirée de l\'architecture marocaine traditionnelle.',
                'desc_ar' => 'مرآة حائط مزخرفة بإطار من فسيفساء الزليج الأصيل. قطعة حرفية فريدة.',
                'short_fr' => 'Miroir zellige, mosaïque artisanale',
                'price' => 699.00, 'old_price' => 899.00, 'stock' => 10, 'featured' => false,
            ],
            [
                'seller_idx' => 4, 'category' => 'maison-decoration',
                'name_fr' => 'Coussin Décoratif Brodé Marocain', 'name_ar' => 'وسادة ديكور مغربية مطرزة',
                'desc_fr' => 'Coussin décoratif avec broderies marocaines traditionnelles. Tissu satiné de qualité. Parfait pour le salon ou la chambre.',
                'desc_ar' => 'وسادة ديكور بتطريز مغربي تقليدي. قماش ساتان عالي الجودة.',
                'short_fr' => 'Coussin brodé, motifs marocains traditionnels',
                'price' => 119.00, 'old_price' => 159.00, 'stock' => 60, 'featured' => false,
            ],
            [
                'seller_idx' => 4, 'category' => 'maison-decoration',
                'name_fr' => 'Fontaine Murale Marocaine en Zellige', 'name_ar' => 'نافورة حائط مغربية بالزليج',
                'desc_fr' => 'Fontaine murale artisanale en zellige et tadelakt. Style marocain authentique. Installation intérieure ou extérieure.',
                'desc_ar' => 'نافورة حائط حرفية من الزليج والتادلاكت. طراز مغربي أصيل.',
                'short_fr' => 'Fontaine zellige et tadelakt, style marocain',
                'price' => 2999.00, 'old_price' => 3800.00, 'stock' => 5, 'featured' => true,
            ],

            // More electronics
            [
                'seller_idx' => 2, 'category' => 'electronique',
                'name_fr' => 'Montre Connectée Sport', 'name_ar' => 'ساعة رياضية ذكية',
                'desc_fr' => 'Montre connectée avec suivi d\'activité, GPS intégré, moniteur cardiaque, résistance à l\'eau 5ATM. 14 jours d\'autonomie.',
                'desc_ar' => 'ساعة ذكية مع تتبع النشاط وGPS مدمج ومراقب نبض القلب.',
                'short_fr' => 'Smartwatch GPS, cardio, 14 jours autonomie',
                'price' => 699.00, 'old_price' => 999.00, 'stock' => 40, 'featured' => false,
            ],
            [
                'seller_idx' => 2, 'category' => 'electromenager',
                'name_fr' => 'Robot de Cuisine Multifonction', 'name_ar' => 'روبوت مطبخ متعدد الوظائف',
                'desc_fr' => 'Robot de cuisine multifonction 1200W avec 12 fonctions: mixer, pétrir, hacher, cuire vapeur. Capacité 4.5L.',
                'desc_ar' => 'روبوت مطبخ متعدد الوظائف 1200 واط مع 12 وظيفة.',
                'short_fr' => 'Robot cuisine 1200W, 12 fonctions, 4.5L',
                'price' => 1499.00, 'old_price' => 1999.00, 'stock' => 25, 'featured' => false, 'brand' => 'moulinex',
            ],

            // More traditional
            [
                'seller_idx' => 1, 'category' => 'artisanat-marocain',
                'name_fr' => 'Décoration Murale Zellige Artisanale', 'name_ar' => 'ديكور حائط زليج حرفي',
                'desc_fr' => 'Panneau décoratif en zellige marocain authentique. Motifs géométriques traditionnels. Pièce unique faite main.',
                'desc_ar' => 'لوحة ديكور من الزليج المغربي الأصيل. أنماط هندسية تقليدية.',
                'short_fr' => 'Panneau zellige, motifs géométriques, fait main',
                'price' => 549.00, 'old_price' => 699.00, 'stock' => 15, 'featured' => false,
            ],

            // Sports
            [
                'seller_idx' => 2, 'category' => 'sports',
                'name_fr' => 'Tapis de Yoga Premium Antidérapant', 'name_ar' => 'بساط يوغا ممتاز مانع للانزلاق',
                'desc_fr' => 'Tapis de yoga professionnel 6mm, surface antidérapante, matériaux écologiques. Sangle de transport incluse.',
                'desc_ar' => 'بساط يوغا احترافي 6 مم، سطح مانع للانزلاق، مواد صديقة للبيئة.',
                'short_fr' => 'Tapis yoga 6mm, antidérapant, écologique',
                'price' => 199.00, 'old_price' => 299.00, 'stock' => 70, 'featured' => false,
            ],

            // Alimentation
            [
                'seller_idx' => 1, 'category' => 'alimentation',
                'name_fr' => 'Miel de Thym du Maroc Pur', 'name_ar' => 'عسل الزعتر المغربي النقي',
                'desc_fr' => 'Miel de thym 100% pur et naturel, récolté dans les montagnes du Rif marocain. Riche en propriétés thérapeutiques.',
                'desc_ar' => 'عسل الزعتر الطبيعي 100% النقي، محصود من جبال الريف المغربية.',
                'short_fr' => 'Miel de thym pur, montagnes du Rif',
                'price' => 149.00, 'old_price' => null, 'stock' => 90, 'featured' => false,
            ],

            // Cadeaux
            [
                'seller_idx' => 4, 'category' => 'cadeaux',
                'name_fr' => 'Coffret Cadeau Marocain Prestige', 'name_ar' => 'علبة هدية مغربية فاخرة',
                'desc_fr' => 'Coffret cadeau luxueux contenant: théière, 2 verres à thé, boîte de thé marocain, miel et pâtisseries marocaines. Emballage premium.',
                'desc_ar' => 'علبة هدية فاخرة تحتوي: إبريق شاي، كأسين، علبة شاي مغربي، عسل وحلويات مغربية.',
                'short_fr' => 'Coffret prestige: thé, miel, pâtisseries marocaines',
                'price' => 499.00, 'old_price' => 650.00, 'stock' => 25, 'featured' => true,
            ],

            // More phones
            [
                'seller_idx' => 2, 'category' => 'telephones-tablettes',
                'name_fr' => 'OPPO A78 5G', 'name_ar' => 'أوبو A78 5G',
                'desc_fr' => 'OPPO A78 5G avec écran LCD 90Hz 6.56", processeur Dimensity 700, 8Go RAM, 128Go. Batterie 5000mAh.',
                'desc_ar' => 'أوبو A78 5G بشاشة LCD بمعدل 90Hz وقياس 6.56 بوصة.',
                'short_fr' => 'OPPO A78 5G - 8Go/128Go - 5000mAh',
                'price' => 2199.00, 'old_price' => 2699.00, 'stock' => 40, 'featured' => false, 'brand' => 'oppo',
            ],
        ];

        foreach ($products as $p) {
            $seller = $sellers[$p['seller_idx']];
            $category = $categories[$p['category']] ?? $categories->first();
            $brandId = null;
            if (isset($p['brand'])) {
                $brand = \App\Models\Brand::where('slug', $p['brand'])->first();
                $brandId = $brand?->id;
            }

            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'brand_id' => $brandId,
                'name_fr' => $p['name_fr'],
                'name_ar' => $p['name_ar'],
                'slug' => Str::slug($p['name_fr']),
                'description_fr' => $p['desc_fr'],
                'description_ar' => $p['desc_ar'] ?? null,
                'short_description_fr' => $p['short_fr'] ?? null,
                'price' => $p['price'],
                'old_price' => $p['old_price'],
                'stock' => $p['stock'],
                'sku' => 'SM-' . strtoupper(Str::random(8)),
                'is_active' => true,
                'is_featured' => $p['featured'] ?? false,
                'rating' => rand(30, 50) / 10,
                'reviews_count' => rand(5, 200),
                'sales_count' => rand(10, 500),
                'views_count' => rand(100, 5000),
            ]);

            // Create a placeholder primary image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => '/images/products/placeholder.jpg',
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            // Create variants if specified
            if (isset($p['variants'])) {
                foreach ($p['variants'] as $v) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'type' => $v['type'],
                        'name' => $v['name'],
                        'value' => $v['value'],
                        'price_adjustment' => $v['adj'] ?? 0,
                        'stock' => $v['stock'],
                    ]);
                }
            }
        }
    }
}
