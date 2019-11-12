<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator\Dictionaries;

/**
 * Class MethodMappings
 * @package KrzysztofRewak\LaravelOOPValidator\Dictionaries
 */
abstract class MethodMappings
{
    /** @var array */
    public const MAPPINGS = [
        "alphabetic" => "alpha",
        "alphabetic_with_dashes" => "alpha_dash",
        "alphanumeric" => "alpha_num",
        "greater_than" => "gt",
        "greater_or_equal_to" => "gte",
        "less_than" => "lt",
        "less_or_equal_to" => "lte",
        "not_regular_expression" => "not_regex",
        "regular_expression" => "regex",
    ];
}