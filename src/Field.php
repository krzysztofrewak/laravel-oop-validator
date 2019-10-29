<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Class Field
 * @package KrzysztofRewak\LaravelOOPValidator
 * @method Contracts\Field accepted()
 * @method Contracts\Field activeUrl()
 * @method Contracts\Field after(string $date)
 * @method Contracts\Field afterOrEqual(string $date)
 * @method Contracts\Field alphabetic()
 * @method Contracts\Field alphabeticWithDashes()
 * @method Contracts\Field alphaNumeric()
 * @method Contracts\Field array()
 * @method Contracts\Field bail()
 * @method Contracts\Field before(string $date)
 * @method Contracts\Field beforeOrEqual(string $date)
 * @method Contracts\Field between(string|int|float|array $min, string|int|float|array $max)
 * @method Contracts\Field boolean()
 * @method Contracts\Field confirmed()
 * @method Contracts\Field date()
 * @method Contracts\Field dateEquals(string $date)
 * @method Contracts\Field dateFormat(string $format)
 * @method Contracts\Field different(string $field)
 * @method Contracts\Field digits(int $value)
 * @method Contracts\Field digitsBetween(int $min, int $max)
 * @method Contracts\Field distinct()
 * @method Contracts\Field email(string ...$validations)
 * @method Contracts\Field endsWith(array $values)
 * @method Contracts\Field exists(string $table, string $column = "")
 * @method Contracts\Field file()
 * @method Contracts\Field filled()
 * @method Contracts\Field greaterThan(string|int|float|array $field)
 * @method Contracts\Field greaterOrEqualTo(string|int|float|array $field)
 * @method Contracts\Field image()
 * @method Contracts\Field in(array $values)
 * @method Contracts\Field inArray(string $anotherField)
 * @method Contracts\Field integer()
 * @method Contracts\Field ip()
 * @method Contracts\Field ipv4()
 * @method Contracts\Field ipv6()
 * @method Contracts\Field json()
 * @method Contracts\Field lessThan(string|int|float|array $field)
 * @method Contracts\Field lessOrEqualTo(string|int|float|array $field)
 * @method Contracts\Field max(int $value)
 * @method Contracts\Field mimetypes(array $mimetypes)
 * @method Contracts\Field mimes(array $mimes)
 * @method Contracts\Field min(int $value)
 * @method Contracts\Field notIn(array $values)
 * @method Contracts\Field notRegex(string $pattern)
 * @method Contracts\Field notRegularExpression(string $pattern)
 * @method Contracts\Field nullable()
 * @method Contracts\Field numeric()
 * @method Contracts\Field present()
 * @method Contracts\Field regex(string $pattern)
 * @method Contracts\Field regularExpression(string $pattern)
 * @method Contracts\Field required()
 * @method Contracts\Field requiredIf(string $field, string|int|float $value)
 * @method Contracts\Field requiredUnless(string $field, string|int|float $value)
 * @method Contracts\Field requiredWith(string ...$fields)
 * @method Contracts\Field requiredWithAll(string ...$fields)
 * @method Contracts\Field requiredWithout(string ...$fields)
 * @method Contracts\Field requiredWithoutAll(string ...$fields)
 * @method Contracts\Field same(string $field)
 * @method Contracts\Field size(int $value)
 * @method Contracts\Field startsWith(array $values)
 * @method Contracts\Field string()
 * @method Contracts\Field timezone()
 * @method Contracts\Field unique(string $table, string $column, string $except = "", string $idColumn = "")
 * @method Contracts\Field url()
 * @method Contracts\Field uuid()
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
    protected function mapArguments(array $arguments): string
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