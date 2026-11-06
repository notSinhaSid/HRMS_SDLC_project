<?php

namespace App\Enums;

enum LoginResult
{
    case Success;
    case InvalidCredentials;
    case Deactivated;
    case LockedOut;

}
