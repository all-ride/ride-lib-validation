<?php

namespace pallo\library\validation;

use \PHPUnit_Framework_TestCase;

class ValidationErrorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerToString
     */
    public function testToString($code, $message, array $parameters, $expected) {
        $error = new ValidationError($code, $message, $parameters);
        $this->assertEquals($expected, $error->__toString(), $code);
    }

    public function providerToString() {
        return array(
            array('code', 'Your message', array(), 'Your message'),
            array('code', 'Your message: %message%', array('message' => 'string'), 'Your message: string'),
            array('code', 'You have %item% in %container%', array('item' => 'a cat', 'container' => 'your bag'), 'You have a cat in your bag'),
            array('code', 'You have a %item%', array('item' => $this), 'You have a object'),
        );
    }

    /**
     * @dataProvider providerConstructThrowsExceptionWhenInvalidValueProvided
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWhenInvalidCodeProvided($code) {
        new ValidationError($code, 'message');
    }

    /**
     * @dataProvider providerConstructThrowsExceptionWhenInvalidValueProvided
     * @expectedException InvalidArgumentException
     */
    public function testConstructThrowsExceptionWhenInvalidMessageProvided($message) {
        new ValidationError('code', $message);
    }

    public function providerConstructThrowsExceptionWhenInvalidValueProvided() {
        return array(
            array(''),
            array(null),
            array($this),
        );
    }

}