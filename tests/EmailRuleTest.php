<?php

declare(strict_types = 1);

use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailRuleTest
 */
final class EmailRuleTest extends TestCase
{
    /**
     * Test if building simple email validation rule without parameters works properly
     */
    public function testSimpleEmailValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("email", function (Field $field): void {
            $field->email();
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["email"], $rules["email"]);
    }

    /**
     * Test if building simple email validation rule with additional validator works properly
     */
    public function testRfcEmailValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("email", function (Field $field): void {
            $field->email("rfc");
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["email:rfc"], $rules["email"]);
    }

    /**
     * Test if building simple email validation rule with additional validators works properly
     */
    public function testMultipleValidatorsEmailValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("email", function (Field $field): void {
            $field->email("rfc", "dns");
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["email:rfc,dns"], $rules["email"]);
    }
}