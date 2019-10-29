<?php

declare(strict_types = 1);

use Illuminate\Validation\Rules\Dimensions;
use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class DimensionsRuleTest
 */
final class DimensionsRuleTest extends TestCase
{
    /**
     * Test if building simple email validation rule without parameters works properly
     */
    public function testDimensionsValidation(): void
    {
        $builder = new ValidationBuilder();
        $builder->validate("avatar", function (Field $field): void {
            $field->dimensions(function(Dimensions $dimensions): void {
                $dimensions->ratio(3/2)->width(100);
            });
        });

        $rules = $builder->getRules();

        $this->assertCount(1, $rules);
        $this->assertEquals("dimensions:ratio=1.5,width=100", $rules["avatar"]);
    }
}