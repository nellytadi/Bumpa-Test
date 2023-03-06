<?php


namespace App\Repositories;


use App\Models\Badge;

class BadgeRepository
{
    public function getUserNextBadge($currentBadge){
        return Badge::select('name')->where('order', $currentBadge->order + 1)->first();
    }

}