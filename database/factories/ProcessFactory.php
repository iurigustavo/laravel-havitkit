<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Organization;
use App\Models\PhaseType;
use App\Models\Process;
use App\Models\SubjectType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProcessFactory extends Factory
{
    protected $model = Process::class;

    public function definition(): array
    {
        return [
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
            'description' => $this->faker->text(),
            'year'        => $this->faker->randomNumber(),
            'is_private'  => $this->faker->boolean(),
            'code'        => $this->faker->word(),
            'expires_at'  => Carbon::now(),
            'archived_at' => Carbon::now(),

            'user_id'         => User::factory(),
            'subject_type_id' => SubjectType::factory(),
            'phase_type_id'   => PhaseType::factory(),
            'organization_id' => Organization::factory(),
            'department_id'   => Department::factory(),
        ];
    }
}
