<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Repositories\AchievementRepository;
use App\Repositories\BadgeRepository;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    protected AchievementRepository $achievementRepository;
    protected BadgeRepository $badgeRepository;

    public function __construct(AchievementRepository $achievementRepository, BadgeRepository $badgeRepository) {
        $this->achievementRepository = $achievementRepository;
        $this->badgeRepository = $badgeRepository;
    }

    public function getUserAchievementDetails($user) {
        $user = User::find($user);

        $unlockedAchievements = $user->achievements;
        $unlockedAchievementsIds = $unlockedAchievements->pluck('id');

        $nextAvailableAchievements = $this->achievementRepository->getNamesOfNextAvailableAchievements($unlockedAchievementsIds);

        $currentBadge = $user->badges()->latest()->first();
        $nextBadge = $this->badgeRepository->getUserNextBadge($currentBadge);

        $remainingToUnlockNextBadge = (new AchievementService($user))->getAchievementsRequiredToUnlockBadge();

        return [
            "unlocked_achievements" => $unlockedAchievements->pluck('name'),
            "next_available_achievements" => $nextAvailableAchievements,
            "current_badge" => $currentBadge->name,
            "next_badge" => $nextBadge->name,
            "remaining_to_unlock_next_badge" => $remainingToUnlockNextBadge,
        ];
    }


}
