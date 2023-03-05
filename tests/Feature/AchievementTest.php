<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AchievementTest extends TestCase
{

    public function test_shouldUnlockFirstPurchaseAchievementWhenUserPurchasesFirstProduct() {
        //GIVEN
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();

        //WHEN
        $this->call('POST', 'api/user/purchase/product', ['product_id' => $product->id]);

        //THEN
        $achievement = $user->achievements()->first();
        $this->assertTrue($achievement->name == Achievement::FIRST_ACHIEVEMENT);

    }

    public function test_shouldUnlockFivePurchaseAchievementWhenUserPurchasesFiveProducts() {
        //GIVEN
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();
        Purchase::factory()
            ->count(4)
            ->create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
        //WHEN
        $this->call('POST', 'api/user/purchase/product', ['product_id' => $product->id]);

        //THEN
        $achievement = $user->achievements()->latest()->first();
        $this->assertTrue($achievement->name == Achievement::FIVE_PURCHASES_ACHIEVEMENT);

    }

    public function test_shouldEnsureAchievementUnlockedEventIsTriggered(){
        //GIVEN
        Event::fake();
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();

        //WHEN
        $this->call('POST', 'api/user/purchase/product', ['product_id' => $product->id]);

        //THEN - Event is triggered
        Event::assertDispatched(AchievementUnlocked::class);
    }
}
