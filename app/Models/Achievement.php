<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

     const NUMBER_OF_ACHIEVEMENTS_REQUIRED_TO_UNLOCK_BADGE = 3;
     const FIRST_ACHIEVEMENT = "First Purchase Achievement";
     const FIVE_PURCHASES_ACHIEVEMENT = "Five Purchases Achievement";
}
