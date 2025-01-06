<?php

namespace Ibericode\Vat\Bundle\Tests\Validator\Constraints;

use Ibericode\Vat\Bundle\Validator\Constraints\VatNumber;
use Ibericode\Vat\Bundle\Validator\Constraints\VatNumberValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class VatNumberValidatorTest extends ConstraintValidatorTestCase
{

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new VatNumberValidator();
    }

    public function testNullIsValid()
    {
        $this->validator->validate(null, new VatNumber());
        $this->assertNoViolation();
    }

    public function testBlankIsValid()
    {
        $this->validator->validate('', new VatNumber());
        $this->assertNoViolation();
    }

    public function testGoogleIrelandIsValid()
    {
        $this->validator->validate('IE6388047V', new VatNumber());
        $this->assertNoViolation();
    }

    /**
     * @dataProvider getInvalidValues
     */
    public function testInvalidValues($value)
    {
        $constraint = new VatNumber([
            'message' => 'myMessage',
        ]);
        $this->validator->validate($value, $constraint);
        $this->buildViolation('myMessage')
            ->setParameter('{{ string }}', $value)
            ->setCode('59421d43-d474-489c-b18c-7701329d51a0')
            ->assertRaised();
    }

    public static function getInvalidValues()
    {
       return [
           ['NL123'],
           ['DE500'],
       ];
    }




}