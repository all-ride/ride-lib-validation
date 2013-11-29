<?php

namespace pallo\library\validation\validator;

use pallo\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class NumericValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value) {
        $validator = new NumericValidator();

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $expectedParameters = array('value' => $value);
            $expectedError = new ValidationError(NumericValidator::CODE, NumericValidator::MESSAGE, $expectedParameters);

            $resultErrors = $validator->getErrors();

            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
           array(true, 15),
           array(true, '15'),
           array(false, ''),
           array(false, '12test'),
           array(true, '0'),
        );
    }

}