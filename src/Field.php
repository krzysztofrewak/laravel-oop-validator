<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Class Field
 * @package KrzysztofRewak\LaravelOOPValidator
 * @method Field accepted()
 * @method Field activeUrl()
 * @method Field after(string $date)
 * @method Field afterOrEqual(string $date)
 * @method Field alphabetic()
 * @method Field alphabeticWithDashes()
 * @method Field alphaNumeric()
 * @method Field array()
 * @method Field bail()
 * @method Field before(string $date)
 * @method Field beforeOrEqual(string $date)
 * @method Field between(string|int|float|array $min, string|int|float|array $max)
 * @method Field boolean()
 * @method Field confirmed()
 * @method Field date()
 * @method Field dateEquals(string $date)
 * @method Field dateFormat(string $format)
 * @method Field different(string $field)
 * @method Field digits(int $value)
 * @method Field digitsBetween(int $min, int $max)
 * @method Field distinct()
 * @method Field email(string ...$validations)
 * @method Field endsWith(array $values)
 * @method Field exists(string $table, string $column = "")
 * @method Field file()
 * @method Field filled()
 * @method Field greaterThan(string|int|float|array $field)
 * @method Field greaterOrEqualTo(string|int|float|array $field)
 * @method Field image()
 * @method Field in(array $values)
 * @method Field inArray(string $anotherField)
 * @method Field integer()
 * @method Field ip()
 * @method Field ipv4()
 * @method Field ipv6()
 * @method Field json()
 * @method Field lessThan(string|int|float|array $field)
 * @method Field lessOrEqualTo(string|int|float|array $field)
 * @method Field max(int $value)
 * @method Field mimetypes(array $mimetypes)
 * @method Field mimes(array $mimes)
 * @method Field min(int $value)
 * @method Field notIn(array $values)
 * @method Field notRegex(string $pattern)
 * @method Field notRegularExpression(string $pattern)
 * @method Field nullable()
 * @method Field numeric()
 * @method Field present()
 * @method Field regex(string $pattern)
 * @method Field regularExpression(string $pattern)
 * @method Field required()
 * @method Field requiredIf(string $field, string|int|float $value)
 * @method Field requiredUnless(string $field, string|int|float $value)
 * @method Field requiredWith(string ...$fields)
 * @method Field requiredWithAll(string ...$fields)
 * @method Field requiredWithout(string ...$fields)
 * @method Field requiredWithoutAll(string ...$fields)
 * @method Field same(string $field)
 * @method Field size(int $value)
 * @method Field startsWith(array $values)
 * @method Field string()
 * @method Field timezone()
 * @method Field unique(string $table, string $column, string $except = "", string $idColumn = "")
 * @method Field url()
 * @method Field uuid()
 */
class Field implements Contracts\Field
{
    /** @var array */
    protected const MAPPINGS = [
        "alphabetic" => "alpha",
        "alphabetic_with_dashes" => "alpha_dash",
        "alpha_numeric" => "alpha_num",
        "greater_than" => "gt",
        "greater_or_equal_to" => "gte",
        "less_than" => "lt",
        "less_or_equal_to" => "lte",
        "not_regular_expression" => "not_regex",
        "regular_expression" => "regex",
    ];

    /** @var array */
    protected $rules = [];

    /**
     * @param string $name
     * @param array $arguments
     * @return Contracts\Field
     */
    public function __call(string $name, array $arguments = []): Contracts\Field
    {
        $rule = Str::snake($name);
        $rule = $this->mapRuleName($rule);
        $rule .= $this->mapArguments($arguments);
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * @param Closure $closure
     * @return Contracts\Field
     */
    public function dimensions(Closure $closure): Contracts\Field
    {
        $dimensions = Rule::dimensions();
        $closure->call($dimensions, $dimensions);
        $this->rules[] = $dimensions;
        return $this;
    }

    /**
     * @param string $table
     * @param Closure $closure
     * @return Contracts\Field
     */
    public function existsByQuery(string $table, Closure $closure): Contracts\Field
    {
        $query = Rule::exists($table);
        $closure->call($query, $query);
        $this->rules[] = $query;
        return $this;
    }

    /**
     * @param string $rule
     * @return Contracts\Field
     */
    public function custom(string $rule): Contracts\Field
    {
        $this->rules[] = $rule;
        return $this;
    }

    /**
     * @return string
     */
    public function getRules(): string
    {
        return implode("|", $this->rules);
    }

    /**
     * @param string $rule
     * @return string
     */
    protected function mapRuleName(string $rule): string
    {
        if (in_array($rule, array_keys(static::MAPPINGS))) {
            return static::MAPPINGS[$rule];
        }

        return $rule;
    }

    /**
     * @param array $arguments
     * @return string
     */
    protected function mapArguments(array $arguments)
    {
        if ($arguments) {
            $arguments = collect($arguments)->map(function ($argument): string {
                if (is_array($argument)) {
                    return implode(",", $argument);
                }
                return (string)$argument;
            })->toArray();

            return ":" . implode(",", $arguments);
        }

        return "";
    }
}