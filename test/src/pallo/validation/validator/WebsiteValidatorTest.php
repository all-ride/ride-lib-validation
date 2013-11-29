<?php

namespace pallo\library\validation\validator;

use pallo\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class WebsiteValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value) {
        $validator = new WebsiteValidator();

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result, $value);

        if (!$expected) {
            $regex = $validator->getRegex();

            $expectedParameters = array(
                'value' => $value,
                'regex' => $regex
            );
            $expectedError = new ValidationError(WebsiteValidator::CODE, WebsiteValidator::MESSAGE, $expectedParameters);

            $resultErrors = $validator->getErrors();

            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
           array(true, 'http://www.google.com'),
           array(false, 'www.google.com'),
        );
    }

}