<?php

namespace pallo\library\validation\validator;

use pallo\library\validation\ValidationError;

use \Exception;
use \PHPUnit_Framework_TestCase;

class MinMaxValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWithoutMinimumAndMaximum() {
        new MinMaxValidator(array('unused' => 5));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWithInvalidMinimum() {
        new MinMaxValidator(array(MinMaxValidator::OPTION_MINIMUM => 'invalid'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWithInvalidMaximum() {
        new MinMaxValidator(array(MinMaxValidator::OPTION_MAXIMUM => 'invalid'));
    }

    /**
     * @dataProvider providerIsValidWithMinimum
     */
    public function testIsValidWithMinimum($expected, $value, $minimum) {
        $validator = new MinMaxValidator(array(MinMaxValidator::OPTION_MINIMUM => $minimum));

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $resultErrors = $validator->getErrors();
            $expectedParameters = array(
                'value' => $value,
                'minimum' => $minimum,
            );
            $expectedError = new ValidationError(MinMaxValidator::CODE_MINIMUM, MinMaxValidator::MESSAGE_MINIMUM, $expectedParameters);
            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValidWithMinimum() {
        return array(
           array(false, 15, 20),
           array(true, '40', 20),
           array(true, '100', 20),
           array(true, '20', 20),
           array(false, '19', 20),
        );
    }

    /**
     * @dataProvider providerIsValidWithMaximum
     */
    public function testIsValidWithMaximum($expected, $value, $maximum) {
        $validator = new MinMaxValidator(array(MinMaxValidator::OPTION_MAXIMUM => $maximum));

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $resultErrors = $validator->getErrors();
            $expectedParameters = array(
                'value' => $value,
                'maximum' => $maximum,
            );
            $expectedError = new ValidationError(MinMaxValidator::CODE_MAXIMUM, MinMaxValidator::MESSAGE_MAXIMUM, $expectedParameters);
            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValidWithMaximum() {
        return array(
           array(true, 15, 50),
           array(true, '40', 50),
           array(false, '223.56', 50),
           array(false, '100', 50),
           array(true, '20', 50),
           array(true, '50', 50),
        );
    }

    /**
     * @dataProvider providerIsValidWithMinimumAndMaximum
     */
    public function testIsValidWithMinimumAndMaximum($expected, $value, $minimum, $maximum) {
        $validator = new MinMaxValidator(array(MinMaxValidator::OPTION_MINIMUM => $minimum, MinMaxValidator::OPTION_MAXIMUM => $maximum));

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $resultErrors = $validator->getErrors();
            $expectedParameters = array(
                'value' => $value,
                'minimum' => $minimum,
                'maximum' => $maximum,
            );
            $expectedError = new ValidationError(MinMaxValidator::CODE_MINMAX, MinMaxValidator::MESSAGE_MINMAX, $expectedParameters);
            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValidWithMinimumAndMaximum() {
        return array(
           array(false, 15, 20, 50),
           array(true, '40', 20, 50),
           array(false, '223.56', 20, 50),
           array(false, '100', 20, 50),
           array(true, '20', 20, 50),
           array(true, '50', 20, 50),
           array(false, '-15', 0, 50),
        );
    }

}