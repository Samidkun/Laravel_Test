<?php

namespace Database\Seeders;

use App\Models\MasterDepartement;
use Illuminate\Database\Seeder;

class seedertabelmasterdepartement extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['id' => 1, 'name' => 'accounting'],
            ['id' => 2, 'name' => 'bussines development'],
            ['id' => 3, 'name' => 'enginering'],
            ['id' => 4, 'name' => 'human resource'],
            ['id' => 5, 'name' => 'legal'],
            ['id' => 6, 'name' => 'marketing'],
            ['id' => 7, 'name' => 'product management'],
            ['id' => 8, 'name' => 'sales'],
            ['id' => 9, 'name' => 'training'],
        ];

        foreach ($departments as $dept) {
            MasterDepartement::updateOrCreate(
                ['id' => $dept['id']],
                ['name' => $dept['name']]
            );
        }
    }
}