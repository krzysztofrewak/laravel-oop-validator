<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator\Contracts;

use Closure;

/**
 * Interface ValidationBuilder
 * @package KrzysztofRewak\LaravelOOPValidator\Contracts
 */
interface ValidationBuilder
{
    /**
     * @return array
     */
    public function getRules(): array;

    /**
     * @param string $fieldName
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validate(string $fieldName, Closure $lambda): ValidationBuilder;

    /**
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateEach(string $array, Closure $lambda): ValidationBuilder;

    /**
     * @param string $field
     * @param string $array
     * @param Closure $lambda
     * @return ValidationBuilder
     */
    public function validateInEach(string $field, string $array, Closure $lambda): ValidationBuilder;
}