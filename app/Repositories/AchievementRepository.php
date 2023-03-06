<?php


namespace App\Repositories;


use App\Models\Achievement;

class AchievementRepository
{
    public function getNamesOfNextAvailableAchievements($unlockedAchievementsIds){
        $nextAvailableAchievements = Achievement::whereNotIn('id',$unlockedAchievementsIds)->get();
        return $nextAvailableAchievements->pluck('name');
    }

}