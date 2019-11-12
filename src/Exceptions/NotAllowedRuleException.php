<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator\Exceptions;

use Exception;

/**
 * Class NotAllowedRuleException
 * @package KrzysztofRewak\LaravelOOPValidator\Exceptions
 */
class NotAllowedRuleException extends Exception
{
    protected $message = "You cannot use Closure- and Rule-based custom field in pipelined validator.";
}