<?php

namespace App\Enums;

enum MeetingRequestStatus: int
{
    case Open = 1;
    case Processed = 2;
    case Rejected = 3;
}
