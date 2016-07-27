<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\RequiredValidator;

use \PHPUnit_Framework_TestCase;

class EqualsConstraintTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->constraint = new EqualsConstraint();
        $this->constraint->addProperty('password');
        $this->constraint->addProperty('password2');
    }

    public function testConstrain() {
        $instance = array(
            'password' => 'my super secret',
            'password2' => 'my super secret',
        );

        $result = $this->constraint->constrain($instance);

        $this->assertEquals($instance, $result);
    }

    /**
     * @dataProvider providerConstrainWithInvalidData
     */
    public function testConstrainFillsValidationException($instance, $numExpectedErrors) {
        $exception = new ValidationException();

        $this->constraint->constrain($instance, $exception);

        $this->assertEquals($numExpectedErrors, count($exception->getAllErrors()));
    }

    /**
     * @dataProvider providerConstrainWithInvalidData
     * @expectedException ride\library\validation\exception\ValidationException
     */
    public function testConstrainThrowsValidationException($instance) {
        $this->constraint->constrain($instance);
    }

    public function providerConstrainWithInvalidData() {
        return array(
            array(
                array(
                    'password' => 'my super secret',
                    'password2' => null,
                ),
                1,
            ),
            array(
                array(
                    'password' => null,
                    'password2' => 'my super secret',
                ),
                1,
            ),
        );
    }

}
