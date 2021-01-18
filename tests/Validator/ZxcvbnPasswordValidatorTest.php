<?php

namespace Locastic\Component\ZxcvbnPasswordValidator\Tests\Validator;

use Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints\ZxcvbnPassword;
use Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints\ZxcvbnPasswordValidator;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ZxcvbnPasswordValidatorTest extends ConstraintValidatorTestCase
{

    public function testNullIsValid()
    {
        $this->validator->validate(null, new ZxcvbnPassword(['minScore' => 3]));

        $this->assertNoViolation();
    }

    public function testEmptyIsValid()
    {
        $this->validator->validate('', new ZxcvbnPassword(['minScore' => 3]));

        $this->assertNoViolation();
    }

    public function testExpectsStringCompatibleType()
    {
        $this->expectException(\Symfony\Component\Validator\Exception\UnexpectedTypeException::class);
        $this->validator->validate(new \stdClass(), new ZxcvbnPassword(['minScore' => 3]));
    }


    public function testWeakPasswordsWillNotPass()
    {
        $constraint = new ZxcvbnPassword(['minScore' => 3]);
        $this->validator->validate('password', $constraint);

        $parameters = [
            '{{ min_score }}' => 3,
            '{{ current_score }}' => 0.0,
        ];

        $this->buildViolation('password_too_weak')
            ->setParameters($parameters)
            ->assertRaised();
    }

    public function testStrongPasswordsWillPass()
    {
        $constraint = new ZxcvbnPassword(['minScore' => 3]);
        $this->validator->validate('Ca@ see alpha Lorem Ipsum danlsdla', $constraint);

        $this->assertNoViolation();
    }

    protected function createValidator()
    {
        return new ZxcvbnPasswordValidator(new Translator('en'));
    }
}