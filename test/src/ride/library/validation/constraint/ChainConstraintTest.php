<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\RequiredValidator;

use \PHPUnit_Framework_TestCase;

class ChainConstraintTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $conditionalConstraint = new ConditionalConstraint();
        $conditionalConstraint->addValueCondition('type', 'url');
        $conditionalConstraint->addValidator(new RequiredValidator(), 'url');

        $equalsConstraint = new EqualsConstraint();
        $equalsConstraint->addProperty('password');
        $equalsConstraint->addProperty('password2');

        $this->constraint = new ChainConstraint();
        $this->constraint->addConstraint($conditionalConstraint);
        $this->constraint->addConstraint($equalsConstraint);
    }

    /**
     * @dataProvider providerConstrain
     */
    public function testConstrain($instance) {
        $result = $this->constraint->constrain($instance);

        $this->assertEquals($instance, $result);
    }

    public function providerConstrain() {
        return array(
            array(
                array(
                    'type' => 'url',
                    'url' => 'http://somesite.com',
                    'password' => 'my super secret',
                    'password2' => 'my super secret',
                ),
                array(
                    'type' => 'node',
                    'url' => null,
                    'password' => null,
                    'password2' => null
                ),
            ),
        );
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
                    'type' => 'url',
                    'url' => null,
                    'password' => 'my super secret',
                    'password2' => 'my super',
                ),
                2,
            ),
            array(
                array(
                    'type' => 'url',
                    'url' => null,
                    'password' => 'my super secret',
                    'password2' => 'my super secret',
                ),
                1,
            ),
            array(
                array(
                    'type' => 'url',
                    'url' => 'http://somesite.com',
                    'password' => 'my super secret',
                    'password2' => 'my super',
                ),
                1,
            ),
        );
    }

}
