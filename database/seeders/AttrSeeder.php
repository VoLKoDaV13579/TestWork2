<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class AttrSeeder extends Seeder
{

    public function run()
    {

        $attributes = [
            ['name' => 'Цвет'],
            ['name' => 'Размер'],
            ['name' => 'Материал'],
            ['name' => 'Вес'],
            ['name' => 'Бренд'],
            ['name' => 'Гарантия'],
        ];


        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
