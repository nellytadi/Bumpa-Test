<?php


namespace App\Services;

use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use Exception;
use Illuminate\Support\Facades\Auth;


class AchievementService
{
    public $user;
    public Achievement|null $achievement = null;

    public function __construct($user) {
        $this->user = $user;
    }

    /**
     * @throws \Exception
     */
    public function checkAndUpdateUserAchievement() {
        $this->unlockFirstAchievement();
        $this->unlockFivePurchasesAchievement();
        (new BadgeService(Auth::user()))->checkAndUpdateUserBadge();

    }


    public function unlockFirstAchievement() {
        $countOfUsersPurchases = $this->user->purchases->count();
        if ($countOfUsersPurchases === 1) {
            $this->achievement = Achievement::where('name', Achievement::FIRST_ACHIEVEMENT)->first();
            $this->user->achievements()->attach($this->achievement->id);
            $this->triggerAchievementUnlockedEvent();
        }

    }

    private function triggerAchievementUnlockedEvent() {
        if (!is_null($this->achievement)) {
            try {
                AchievementUnlocked::dispatch(Auth::user(), $this->achievement->name);
            } catch (Exception $exception) {
                throw new Exception($exception->getMessage());
            }
        }
    }

    public function unlockFivePurchasesAchievement() {
        $countOfUsersPurchases = $this->user->purchases->count();
        if ($countOfUsersPurchases === 5) {
            $this->achievement = Achievement::where('name', Achievement::FIVE_PURCHASES_ACHIEVEMENT)->first();
            $this->user->achievements()->attach($this->achievement->id);
            $this->triggerAchievementUnlockedEvent();
        }
    }


}