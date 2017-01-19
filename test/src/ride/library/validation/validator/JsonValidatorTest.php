<?php

namespace ride\library\validation\validator;

use ride\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class JsonValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value, $expectedError = null) {
        $validator = new JsonValidator();

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result);

        if (!$expected) {
            $resultErrors = $validator->getErrors();

            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
            array(false, null, new ValidationError(RequiredValidator::CODE, RequiredValidator::MESSAGE)),
            array(false, '', new ValidationError(RequiredValidator::CODE, RequiredValidator::MESSAGE)),
            array(false, '{ sme', new ValidationError(JsonValidator::CODE, JsonValidator::MESSAGE, array(
                'value' => '{ sme',
                'message' => 'Syntax error',
            ))),
            array(true, 15),
            array(true, '"test"'),
            array(true, '{}'),
            array(true, '{ "value": 15 }'),
        );
    }

}
