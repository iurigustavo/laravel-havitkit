<?php

namespace Database\Factories;

use App\Models\PhaseType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PhasesTypeFactory extends Factory
{
    protected $model = PhaseType::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name'       => $this->faker->name(),
        ];
    }
}
