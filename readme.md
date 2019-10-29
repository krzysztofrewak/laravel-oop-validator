# laravel-oop-validator
Package was created for Laravel developers who need for some reason object-oriented approach to validation. It basically maps all string rules into easy manageable chained methods. 

## Installation
Use composer:
```
composer require krzysztofrewak/laravel-oop-validator
```

## Usage
Most of the Laravel validation rules were mapped into `Field` methods.

For example code belows will produce validation rules as in comment:
```php
$validator = new ValidationBuilder();
$validator->validate("email", function (Field $field): void {
    $field->string()->required()->email(["rfc"])
});

$validator->getRules();
// ["email" => "string|required|email:rfc"]
```

More complex chain could look like this:
```php
$validator = new ValidationBuilder();
$validator->validate("avatar", function (Field $field): void {
    $field->required()
        ->mimes(["jpeg", "png"])
        ->unique("users", "avatar")
        ->dimensions(function(Dimensions $dimensions): void {
			$dimensions->ratio(3/2);
		});
});

$validator->getRules();
// ["avatar" => "required|mimes:jpeg,png|unique:users,avatar|dimensions:ratio=1.5"]
```

Nested validation rules could look like this:
```php
$validator = new ValidationBuilder();
$validator->validateEach("tags", function (Field $field): void {
    $field->array();
});
$validator->validateInEach("id", "tags", function (Field $field): void {
    $field->required()->exists("tags", "id");
});

$validator->getRules();
// ["tags.*:" => "array", "tags.*.id:" => "required|exists:tags,id"]
```

## Laravel integration
You can  add instance of `ValidationBuilder` into your `FormRequest`'s `rules()` method or any other place where you can put array of rules:

```php
<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use KrzysztofRewak\LaravelOOPValidator\Field;
use KrzysztofRewak\LaravelOOPValidator\ValidationBuilder;

/**
 * Class CreateNewUserRequest
 * @package App\Http\Requests
 */
class CreateNewUserRequest extends FormRequest
{
    /**
     * @var ValidationBuilder
     */
    protected $builder;

    /**
     * CreateNewUserRequest constructor.
     * @param ValidationBuilder $builder
     */
    public function __construct(ValidationBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $this->builder->validate("email", function (Field $field): void {
            $field->required()->string()->email()->unique("users", "email");
        });
        $this->builder->validate("password", function (Field $field): void {
            $field->required()->string()->min(6)->confirmed();
        });

        return $this->builder->getRules();
    }
}
```