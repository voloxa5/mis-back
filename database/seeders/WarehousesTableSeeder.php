<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inventory_items')->delete();
        DB::table('warehouses')->delete();
        DB::table('warehouses')->insert(
            [
                [
                    'title' => 'СВТ',
                    'name' => 'SVT',
                ],
                [
                    'title' => 'ОТО',
                    'name' => 'OTO',
                ],
                [
                    'title' => 'ОКП',
                    'name' => 'OKP',
                ],
            ]
        );

        DB::table('inventory_items')->insert(
            [
                [
                    'title' => 'Монитор FR35',
                    'warehouse_id' => '1',
                    'description' => 'Старый самсунг',
                    'category' => 'устройства вывода',
                    'inventory_number' => '345746',
                ],
                [
                    'title' => 'Манипулятор мышь',
                    'warehouse_id' => '1',
                    'description' => 'Оптическая, белая',
                    'category' => 'устройства ввода',
                    'inventory_number' => '6342',
                ],
                [
                    'title' => 'Фотоаппарат ЕН456',
                    'warehouse_id' => '2',
                    'description' => 'Длиннофокусный',
                    'category' => 'фотоаппараты',
                    'inventory_number' => '74524',
                ],
                [
                    'title' => 'Куртка демисезонная',
                    'warehouse_id' => '3',
                    'description' => 'Зеленая, на синтепоне',
                    'category' => 'зимняя одежда',
                    'inventory_number' => '34584',
                ],
                [
                    'title' => 'Куртка летняя',
                    'warehouse_id' => '3',
                    'description' => 'Розовая',
                    'category' => 'летняя одежда',
                    'inventory_number' => '7563',
                ],
                [
                    'title' => 'Куртка зимняя',
                    'warehouse_id' => '3',
                    'description' => 'С овечьим подкладом',
                    'category' => 'зимняя одежда',
                    'inventory_number' => '865',
                ],
                [
                    'title' => 'Шапка меховая',
                    'warehouse_id' => '3',
                    'description' => 'Из меха шиншиллы',
                    'category' => 'зимняя одежда',
                    'inventory_number' => '64',
                ],
            ]
        );
    }
}
