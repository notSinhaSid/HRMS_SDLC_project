<?php

namespace App\Enums;

enum ResetPasswordResult
{
    case Reset;
    case InvalidUser;
    case InvalidToken;

}
