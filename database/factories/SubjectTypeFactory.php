<?php

namespace Database\Factories;

use App\Models\SubjectType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubjectTypeFactory extends Factory
{
    protected $model = SubjectType::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
