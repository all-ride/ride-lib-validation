<?php

namespace ride\library\validation\validator;

use ride\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class JsonValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value, $expectedMessage = null) {
        $validator = new JsonValidator();

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $expectedParameters = array(
                'value' => $value,
                'message' => $expectedMessage,
            );
            $expectedError = new ValidationError(JsonValidator::CODE, JsonValidator::MESSAGE, $expectedParameters);

            $resultErrors = $validator->getErrors();

            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
           array(false, null, 'Syntax error'),
           array(false, '', 'Syntax error'),
           array(true, 15),
           array(true, '"test"'),
           array(true, '{}'),
           array(true, '{ "value": 15 }'),
       );
    }

}
