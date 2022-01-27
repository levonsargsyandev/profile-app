<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HelperService
{
    static function wordCountChecker($str, $max_count){
        return Str::wordCount($str) <= $max_count;
    }
}
