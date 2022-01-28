<?php

namespace App\Services;

use Illuminate\Support\Str;

class HelperService
{
    /**
     * Check allowed words count of the string.
     *
     * @param string $str
     * @param int $max_count
     * @return bool
     */
    static function wordCountChecker(string $str, int $max_count): bool
    {
        return Str::wordCount($str) <= $max_count;
    }
}
