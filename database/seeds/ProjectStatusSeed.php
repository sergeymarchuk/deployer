<?php

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

/**
 * Class ProjectStatusSeed
 */
class ProjectStatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['title' => 'Active'],
            ['title' => 'Inactive'],
        ];

        foreach ($items as $item) {
            ProjectStatus::create($item);
        }
    }
}
