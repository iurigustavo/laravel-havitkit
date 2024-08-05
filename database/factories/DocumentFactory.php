<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
            'name'        => $this->faker->name(),
            'code'        => $this->faker->word(),
            'year'        => $this->faker->randomNumber(),
            'is_private'  => $this->faker->boolean(),
            'expired_at'  => Carbon::now(),
            'archived_at' => Carbon::now(),

            'document_type_id' => DocumentType::factory(),
            'organization_id'  => Organization::factory(),
            'department_id'    => Department::factory(),
            'user_id'          => User::factory(),
        ];
    }
}
