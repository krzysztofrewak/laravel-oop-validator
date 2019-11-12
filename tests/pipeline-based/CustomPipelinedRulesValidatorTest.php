<?php

declare(strict_types = 1);

use Illuminate\Contracts\Validation\Rule;
use KrzysztofRewak\LaravelOOPValidator\Exceptions\NotAllowedRuleException;
use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\PipelinedValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomPipelinedRulesValidatorTest
 */
final class CustomPipelinedRulesValidatorTest extends TestCase
{
    /**
     * Test if building custom validation rule crashes properly
     */
    public function testCustomRuleValidation(): void
    {
        $builder = new PipelinedValidationBuilder();
        $builder->validate("field", function (Field $field): void {
            $field->customRule(new class implements Rule
            {
                public function passes($attribute, $value): bool
                {
                    return true;
                }

                public function message(): string
                {
                    return "Custom rule failed.";
                }
            });
        });

        $this->expectException(NotAllowedRuleException::class);
        $builder->getRules();
    }
}