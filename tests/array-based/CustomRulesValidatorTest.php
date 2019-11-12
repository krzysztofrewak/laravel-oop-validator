<?php

declare(strict_types = 1);

use Illuminate\Contracts\Validation\Rule;
use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomRulesValidatorTest
 */
final class CustomRulesValidatorTest extends TestCase
{
    /**
     * Test if building custom validation rule works properly
     */
    public function testCustomRuleValidation(): void
    {
        $builder = new ValidationBuilder();
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

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertIsArray($rules["field"]);
        $this->assertEquals([Rule::class => Rule::class], class_implements($rules["field"][0]));
    }
}