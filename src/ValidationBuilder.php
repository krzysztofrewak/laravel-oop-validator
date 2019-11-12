<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator;

use Closure;
use Illuminate\Support\Collection;
use KrzysztofRewak\LaravelOOPValidator\Contracts\Field as FieldInterface;

/**
 * Class ValidationBuilder
 * @package KrzysztofRewak\LaravelOOPValidator
 */
class ValidationBuilder implements Contracts\ValidationBuilder
{
    /** @var FieldInterface[]|Collection */
    protected $rules;

    /**
     * ValidationBuilder constructor.
     */
    public function __construct()
    {
        $this->rules = collect();
    }

    /**
     * @return Field[]
     */
    public function getRules(): array
    {
        return $this->rules->map(function (FieldInterface $field): array {
            return $field->getRules();
        })->toArray();
    }

    /**
     * @param string $fieldName
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validate(string $fieldName, Closure $lambda): Contracts\ValidationBuilder
    {
        $field = $this->createNewField();
        $lambda->call($field, $field);

        $this->rules->put($fieldName, $field);
        return $this;
    }

    /**
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateEach(string $array, Closure $lambda): Contracts\ValidationBuilder
    {
        $this->validate("$array.*", $lambda);
        return $this;
    }

    /**
     * @param string $field
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateInEach(string $field, string $array, Closure $lambda): Contracts\ValidationBuilder
    {
        $this->validate("$array.*.$field", $lambda);
        return $this;
    }

    /**
     * @return Contracts\Field
     */
    protected function createNewField(): Contracts\Field
    {
        return new Field();
    }
}
