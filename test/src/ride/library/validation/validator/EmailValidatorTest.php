<?php

namespace ride\library\validation\validator;

use \PHPUnit_Framework_TestCase;

class EmailValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($value, $expected) {
        $validator = new EmailValidator();

        $this->assertEquals($expected, $validator->isValid($value));
    }

    public function providerIsValid() {
        return array(
            array('info@google.com', true),
            array('www.google.com', false)
        );
    }

}