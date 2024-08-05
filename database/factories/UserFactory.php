<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // hoặc $this->faker->password
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'image' => $this->faker->imageUrl(640, 480, 'people'), // URL hình ảnh giả lập
            'role' => $this->faker->randomElement(User::ROLE),
        ];
    }

}
