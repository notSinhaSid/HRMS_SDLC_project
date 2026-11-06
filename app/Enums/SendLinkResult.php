<?php

namespace App\Enums;

enum SendLinkResult
{
    case Deactivated;
    case NotFound;
    case Throttled;
    case Sent;
}
