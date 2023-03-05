<?php


namespace App\Services;


use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Exception;

class BadgeService
{
    public $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function checkAndUpdateUserBadge() {
        //check if user is due for a new badge
        // Sample - if user has 2,4,6 achievements then assign first, second, third badge respectively
        $userAchievements = $this->user->achievements();
        $countUserAchievements = $userAchievements->count();
        if ($countUserAchievements > 0 && $countUserAchievements % 2 === 0) {
            $badge = Badge::where('order', $countUserAchievements - 1)->first();
            $this->user->badges()->sync($badge->id);
            $this->triggerBadgeUnlockedEvent($badge);
        }

    }

    /**
     * @throws \Exception
     */
    public function triggerBadgeUnlockedEvent($badge){
        try {
            BadgeUnlocked::dispatch($this->user, $badge->name);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}