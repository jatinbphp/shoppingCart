<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Faker\Factory as Faker;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Generate 50 reviews
        for ($i = 0; $i < 200; $i++) {

            $fullName = $faker->name;
            $emailAddress = $faker->unique()->safeEmail;
            $description = $faker->sentence($faker->numberBetween(200, 400));

            Review::create([
                'product_id' => $faker->numberBetween(4, 22),
                'user_id' => $faker->numberBetween(2, 6), // Assuming user ID range from 1 to 10
                'rating' => $faker->numberBetween(1, 5),
                'description' => $description,
                'full_name' => $fullName,
                'email_address' => $emailAddress,
            ]);
        }
    }
}
