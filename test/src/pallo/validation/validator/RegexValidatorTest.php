<?php

namespace pallo\library\validation\validator;

use pallo\library\validation\ValidationError;

use \Exception;
use \PHPUnit_Framework_TestCase;

class RegexValidatorTest extends PHPUnit_Framework_TestCase {

    public function testConstructWithRegex() {
        $regex = 'regex';
        $validator = new RegexValidator(array('regex' => $regex));

        $this->assertEquals($regex, $validator->getRegex());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWithoutRegex() {
        new RegexValidator(array('reg' => 'regex'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWithEmptyRegex() {
        new RegexValidator(array('regex' => ''));
    }

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($value, $expected) {
        $regex = '/regex/';
        $code = 'error.validation.regex';
        $message = 'Field does not match ' . $regex;

        $validator = new RegexValidator(array('regex' => $regex));

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result, $value);

        if (!$expected) {
            $expectedParameters = array(
               'value' => $value,
               'regex' => $regex,
            );
            $expectedErrors = array(new ValidationError($code, $message, $expectedParameters));

            $resultErrors = $validator->getErrors();

            $this->assertEquals($expectedErrors, $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
            array('regex', true),
            array('textregextest', true),
            array('textregtest', false),
        );
    }

}