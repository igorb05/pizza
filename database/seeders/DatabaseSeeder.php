<?php

namespace Database\Seeders;

use App\Models\Pizza;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $config = [
            'sizes' => [
                ['key' => 'small', 'label' => 'Маленькая', 'diameter' => 25, 'multiplier' => 1, 'weight' => 360],
                ['key' => 'medium', 'label' => 'Средняя', 'diameter' => 30, 'multiplier' => 1.2, 'weight' => 450],
                ['key' => 'large', 'label' => 'Большая', 'diameter' => 35, 'multiplier' => 1.4, 'weight' => 600],
            ],
            'crusts' => [
                ['key' => 'traditional', 'label' => 'Традиционное'],
                ['key' => 'thin', 'label' => 'Тонкое'],
            ],
            'addons' => [
                ['key' => 'cheese-side', 'label' => 'Сырный бортик', 'image' => '/images/cheese-side.png', 'price' => 79],
                ['key' => 'mozzarella', 'label' => 'Моцарелла', 'image' => '/images/mozzarella.png', 'price' => 59],
                ['key' => 'cheddar', 'label' => 'Чеддер', 'image' => '/images/cheddar.png', 'price' => 49],
            ],
        ];

        Pizza::create([
            'id' => 1101,
            'name' => 'Сырный цыпленок',
            'description' => 'Цыпленок, моцарелла, сыры чеддер и пармезан, сырный соус, томаты, фирменный соус альфредо, чеснок',
            'config' => $config,
            'tag' => 'сырная',
            'image' => '/images/pizza-1.png',
            'price' => 669,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1102,
            'name' => 'Пепперони',
            'description' => 'Пикантная пепперони, увеличенная порция моцареллы, фирменный томатный соус',
            'config' => $config,
            'tag' => 'колбаски',
            'image' => '/images/pizza-2.png',
            'price' => 519,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1103,
            'name' => 'Гавайская',
            'description' => 'Двойная порция цыпленка, ананасы, моцарелла, фирменный соус альфредо',
            'config' => $config,
            'tag' => 'сладкая',
            'image' => '/images/pizza-3.png',
            'price' => 539,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1104,
            'name' => 'Маргарита',
            'description' => 'Увеличенная порция моцареллы, томаты, итальянские травы, фирменный томатный соус',
            'config' => $config,
            'tag' => 'сырная',
            'image' => '/images/pizza-4.png',
            'price' => 529,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1105,
            'name' => 'Мясная',
            'description' => 'Цыпленок, ветчина, пикантная пепперони, острые колбаски чоризо, моцарелла, фирменный томатный соус',
            'config' => $config,
            'tag' => 'мясная',
            'image' => '/images/pizza-5.png',
            'price' => 609,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1106,
            'name' => 'Песто',
            'description' => 'Цыпленок, соус песто, кубики брынзы, томаты, моцарелла, фирменный соус альфредо',
            'config' => $config,
            'tag' => 'сырная',
            'image' => '/images/pizza-6.png',
            'price' => 649,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1107,
            'name' => 'Креветки со сладким чили',
            'description' => 'Креветки, ананасы, соус сладкий чили, сладкий перец, моцарелла, фирменный соус альфредо',
            'config' => $config,
            'tag' => 'сладкая',
            'image' => '/images/pizza-7.png',
            'price' => 619,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1108,
            'name' => 'Жюльен',
            'description' => 'Цыпленок, шампиньоны, ароматный грибной соус, лук, сухой чеснок, моцарелла, смесь сыров чеддер и пармезан, фирменный соус альфредо',
            'config' => $config,
            'tag' => 'овощная',
            'image' => '/images/pizza-8.png',
            'price' => 619,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1109,
            'name' => 'Овощи и грибы',
            'description' => 'Шампиньоны, томаты, сладкий перец, красный лук, кубики брынзы, моцарелла, фирменный томатный соус, итальянские травы',
            'config' => $config,
            'tag' => 'овощная',
            'image' => '/images/pizza-9.png',
            'price' => 609,
            'is_active' => true,
        ]);

        Pizza::create([
            'id' => 1110,
            'name' => 'Чоризо фреш',
            'description' => 'Острые колбаски чоризо, сладкий перец, моцарелла, фирменный томатный соус',
            'config' => $config,
            'tag' => 'колбаски',
            'image' => '/images/pizza-10.png',
            'price' => 319,
            'is_active' => true,
        ]);
    }
}
