<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'code'        => $this->faker->password(),
            'title'       => $this->faker->word(),
            'description' => $this->faker->text(),
            'status'      => $this->faker->randomElement(TaskStatusEnum::cases()),
            'expires_at'  => Carbon::now(),
            'finished_at' => Carbon::now(),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),

            'assignee_user_id' => User::factory(),
            'reporter_user_id' => User::factory(),
        ];
    }
}
