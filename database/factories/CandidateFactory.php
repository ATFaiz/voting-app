<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidate;

class CandidateFactory extends Factory
{
    protected $model = Candidate::class;

    public function definition()
    {
        return [
            'fullname' => $this->faker->name,
            'constituency' => $this->faker->city,
            'regional' => $this->faker->state,
            'image' => 'default.jpg',
        ];
    }
}
