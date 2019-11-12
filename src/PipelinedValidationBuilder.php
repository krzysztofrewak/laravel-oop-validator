<?php

declare(strict_types = 1);

namespace KrzysztofRewak\LaravelOOPValidator;

use KrzysztofRewak\LaravelOOPValidator\Contracts\Field as FieldInterface;
use KrzysztofRewak\LaravelOOPValidator\Exceptions\NotAllowedRuleException;
use Throwable;

/**
 * Class PipelinedValidationBuilder
 * @package KrzysztofRewak\LaravelOOPValidator
 */
class PipelinedValidationBuilder extends ValidationBuilder
{
    /**
     * @return string[]
     */
    public function getRules(): array
    {
        return $this->rules->map(function (FieldInterface $field): string {
            try {
                $rules = $field->getPipelinedRules();
            } catch (Throwable $throwable) {
                throw new NotAllowedRuleException();
            }

            return $rules;
        })->toArray();
    }
}
