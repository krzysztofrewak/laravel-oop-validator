<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator\Contracts;

use Closure;
use Illuminate\Contracts\Validation\Rule;

/**
 * Interface Field
 * @package KrzysztofRewak\LaravelOOPValidator\Contracts
 * @method Field accepted()
 * @method Field activeUrl()
 * @method Field after(string $date)
 * @method Field afterOrEqual(string $date)
 * @method Field alphabetic()
 * @method Field alphabeticWithDashes()
 * @method Field alphanumeric()
 * @method Field array()
 * @method Field bail()
 * @method Field before(string $date)
 * @method Field beforeOrEqual(string $date)
 * @method Field between(string|int|float|array $min, string|int|float|array $max)
 * @method Field boolean()
 * @method Field confirmed()
 * @method Field custom(string $rule)
 * @method Field customRule(Rule $rule)
 * @method Field customCallback(Closure $closure)
 * @method Field date()
 * @method Field dateEquals(string $date)
 * @method Field dateFormat(string $format)
 * @method Field different(string $field)
 * @method Field digits(int $value)
 * @method Field digitsBetween(int $min, int $max)
 * @method Field dimensions(Closure $closure)
 * @method Field distinct()
 * @method Field email(string ...$validations)
 * @method Field endsWith(array $values)
 * @method Field exists(string $table, string $column = "")
 * @method Field existsByQuery(string $table, Closure $closure)
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
 * @method Field sometimes()
 * @method Field startsWith(array $values)
 * @method Field string()
 * @method Field timezone()
 * @method Field unique(string $table, string $column, string $except = "", string $idColumn = "")
 * @method Field url()
 * @method Field uuid()
 */
interface Field
{
    /**
     * @return array
     */
    public function getRules(): array;
    /**
     * @return string
     */
    public function getPipelinedRules(): string;
}