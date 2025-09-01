<?php

namespace App\Enums;

enum AvailabilityStatus: int
{
    case Empty = 1;
    case Booked = 2;
    case Blocked = 3;
}
