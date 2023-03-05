<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Models\UserBankAccount;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::factory(10)
            ->has(UserBankAccount::factory())
            ->create();

        User::factory()
            ->has(UserBankAccount::factory())
            ->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        Product::factory(30)->create();

        Purchase::factory()
            ->count(50)
            ->state(new Sequence(
                fn(Sequence $sequence) => ['user_id' => User::all()->random()],
                fn(Sequence $sequence) => ['product_id' => Product::all()->random()],
            ))
            ->create();

        $maxAchievementOrder = Achievement::max('order') ?? 0;



        $achievementCount = Achievement::factory(2)
            ->sequence(fn(Sequence $sequence) => ['order' => $sequence->index + $maxAchievementOrder + 1])
            ->sequence(['name' => Achievement::FIRST_ACHIEVEMENT], ['name' => Achievement::FIVE_PURCHASES_ACHIEVEMENT])
            ->create();

        $achievementCount =$achievementCount->count();
        Achievement::factory(5)
            ->sequence(fn(Sequence $sequence) => ['order' => $sequence->index + $achievementCount + 1])
            ->create();

        $maxBadgeOrder = Badge::max('order');

        Badge::factory(5)
            ->sequence(fn(Sequence $sequence) => ['order' => $sequence->index + $maxBadgeOrder + 1])
            ->create();

    }
}
