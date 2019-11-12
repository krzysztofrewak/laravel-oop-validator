<?php

declare(strict_types = 1);

use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class UsingValidatorTest
 */
final class UsingValidatorTest extends TestCase
{
    /**
     * Test if building simple validation rule without parameters works properly
     */
    public function testArrayValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("field", function (Field $field): void {
            $field->array();
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["array"], $rules["field"]);
    }

    /**
     * Test if building two simple validation rules without parameters works properly
     */
    public function testRequiredArrayValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("field", function (Field $field): void {
            $field->array()->required();
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["array", "required"], $rules["field"]);
    }

    /**
     * Test if building validation rule with parameter works properly
     */
    public function testGreaterThanValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("best_before", function (Field $field): void {
            $field->after("today");
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["after:today"], $rules["best_before"]);
    }

    /**
     * Test if building validation rules works properly
     */
    public function testMoreComplicatedRulesetValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("id", function (Field $field): void {
            $field->required()->string()->unique("users", "id")->uuid();
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals(["required", "string", "unique:users,id", "uuid"], $rules["id"]);
    }

    /**
     * Test if building validation rules works properly for multiple fields
     */
    public function testMultipleFieldsUnderValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("id", function (Field $field): void {
            $field->required()->integer()->unique("users", "id");
        });
        $builder->validate("name", function (Field $field): void {
            $field->required()->string();
        });
        $builder->validate("password", function (Field $field): void {
            $field->required()->string()->min(6)->custom("complicated");
        });

        $rules = $builder->getRules();

        $this->assertCount(3, $rules);
        $this->assertEquals(["required", "integer", "unique:users,id"], $rules["id"]);
        $this->assertEquals(["required", "string"], $rules["name"]);
        $this->assertEquals(["required", "string", "min:6", "complicated"], $rules["password"]);
    }
}