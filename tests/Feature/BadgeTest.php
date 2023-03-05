<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Jobs\SendFinancialReward;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Services\BadgeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BadgeTest extends TestCase
{

    public function test_shouldEnsureBadgeIsCreatedAfterCorrectAchievementsHaveBeenFulfilled(): void {
        //GIVEN
        Event::fake();

        $user = User::factory()->create();
        $this->actingAs($user);
        $firstBadge = Badge::where('order', 1)->first();

        //WHEN
        $firstAchievement = Achievement::where('name', Achievement::FIRST_ACHIEVEMENT)->first();
        $user->achievements()->attach($firstAchievement->id);

        $secondAchievement = Achievement::where('name', Achievement::FIVE_PURCHASES_ACHIEVEMENT)->first();
        $user->achievements()->attach($secondAchievement->id);

        $badgeService = new BadgeService($user);

        $badgeService->checkAndUpdateUserBadge();

        //THEN
        $badge = $user->badges()->first();
        $this->assertTrue($badge->name == $firstBadge->name);

    }

    public function test_shouldEnsureBadgeUnlockedEventIsTriggered(): void {
        //GIVEN
        Event::fake();
        $user = User::factory()
            ->has(UserBankAccount::factory())
            ->create();

        $this->actingAs($user);

        //WHEN
        $firstAchievement = Achievement::where('name', Achievement::FIRST_ACHIEVEMENT)->first();
        $user->achievements()->attach($firstAchievement->id);

        $secondAchievement = Achievement::where('name', Achievement::FIVE_PURCHASES_ACHIEVEMENT)->first();
        $user->achievements()->attach($secondAchievement->id);

        $badgeService = new BadgeService($user);
        $badgeService->checkAndUpdateUserBadge();

        //THEN - Event is triggered
        Event::assertDispatched(BadgeUnlocked::class);
    }

    public function test_shouldEnsurePaymentJobIsTriggeredWhenBadgeIsUnlocked(){
        Queue::fake();

        $user = User::factory()
            ->has(UserBankAccount::factory())
            ->create();

        $this->actingAs($user);

        //WHEN
        $firstAchievement = Achievement::where('name', Achievement::FIRST_ACHIEVEMENT)->first();
        $user->achievements()->attach($firstAchievement->id);

        $secondAchievement = Achievement::where('name', Achievement::FIVE_PURCHASES_ACHIEVEMENT)->first();
        $user->achievements()->attach($secondAchievement->id);

        $badgeService = new BadgeService($user);
        $badgeService->checkAndUpdateUserBadge();

        Queue::assertPushed(SendFinancialReward::class);


    }
}
