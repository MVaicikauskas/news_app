<?php

namespace App\Enums;

enum VoteType: int
{
    case LIKE = 1;
    case DISLIKE = -1;
}
