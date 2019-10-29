<?php

declare(strict_types = 1);

use KrzysztofRewak\LaravelOOPValidator\Contracts\Field as FieldContract;
use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class ExtendingValidatorTest
 */
final class ExtendingValidatorTest extends TestCase
{
    /**
     * Test if extending ValidationBuilder with new Field class works properly
     */
    public function testArrayValidation(): void
    {
        $builder = new class extends ValidationBuilder
        {
            protected function createNewField(): FieldContract
            {
                return new class extends Field {
                    public function test(): FieldContract {
                        $this->rules[] = "testing";
                        return $this;
                    }
                };
            }
        };

        $builder->validate("field", function (Field $field): void {
            $field->test();
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals("testing", $rules["field"]);
    }
}