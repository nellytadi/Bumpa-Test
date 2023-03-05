<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public const FIRST_ACHIEVEMENT = "First Purchase Achievement";
    public const FIVE_PURCHASES_ACHIEVEMENT = "Five Purchases Achievement";
}
