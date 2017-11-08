<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 5:03 PM
 */

namespace Course\Api\Exceptions;

use Course\Api\Controllers\ErrorCodes;

class Precondition
{
    public static function isTrue(bool $condition, string $message)
    {
        if ($condition !== true) {
            throw new PreconditionException($message);
        }
    }

    public static function lengthIsBetween($string, $minLength, $maxLength, $variableName)
    {
        $length = strlen($string);
        if (!($length >= $minLength && $length <= $maxLength)) {
            throw new PreconditionException($variableName . ' should be between ' . $minLength . ' and ' . $maxLength . ' characters', ErrorCodes::INVALID_PARAMETER);
        }
    }

    public static function isNotEmpty($value, $variableName)
    {
        if(empty($value))
        {
            throw new PreconditionException($variableName . ' parameter is empty or missing', ErrorCodes::MISSING_PARAMETER);
        }
    }
}