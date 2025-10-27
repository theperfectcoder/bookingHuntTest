<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Hunting\Guide;
use Illuminate\Database\Seeder;

final class GuideSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        Guide::query()->insert([
            ['name' => 'Alexandr', 'experience_years' => 5, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vasilii', 'experience_years' => 2, 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ivan', 'experience_years' => 8, 'is_active' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
