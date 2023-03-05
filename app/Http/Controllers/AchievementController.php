<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementController extends Controller
{


    public function getUserAchievementDetails($user) {
        $user = User::find($user);
        $unlockedAchievements = $user->achievements;
        $unlockedAchievementsNames = $unlockedAchievements->pluck('name');
        $unlockedAchievementsIds = $unlockedAchievements->pluck('id');

        $nextAvailableAchievements = Achievement::whereNotIn('id',$unlockedAchievementsIds)->get();
        $nextAvailableAchievements = $nextAvailableAchievements->pluck('name');

        $currentBadge = $user->badges()->latest()->first();
        $nextBadge = Badge::select('name')->where('order', $currentBadge->order + 1)->first();


        return [
            "unlocked_achievements" => $unlockedAchievementsNames,
            "next_available_achievements" => $nextAvailableAchievements,
            "current_badge" => $currentBadge->name,
            "next_badge" => $nextBadge->name,
            "remaining_to_unlock_next_badge" => 0,
        ];
    }


}
