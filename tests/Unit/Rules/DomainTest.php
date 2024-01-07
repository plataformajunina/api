<?php

use App\Rules\Domain;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

uses(TestCase::class);

test('domain passes', function () {
    $rule = new Domain('example.com');

    $data = ['email' => 'name@example.com'];

    $validator = Validator::make($data, ['email' => [$rule]]);

    expect($validator->fails())->toBeFalse();
});

test('domain fails', function (string $email) {
    $rule = new Domain('example.com');

    $data = ['email' => $email];

    $validator = Validator::make($data, ['email' => [$rule]]);

    expect($validator->fails())->toBeTrue();
})->with([
    'example',
    'example.',
    '.com',
    'com',
    'example.com.br',
    'example.com'
]);
