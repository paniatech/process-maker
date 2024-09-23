<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Form::factory()->create([
            'name' => 'estate',
            'description' => ' Registration information about the sides of the estate',
        ]);
    }
}
