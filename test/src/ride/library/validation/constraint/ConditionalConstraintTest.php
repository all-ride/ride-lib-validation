<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\RequiredValidator;

use \PHPUnit_Framework_TestCase;

class ConditionalConstraintTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->constraint = new ConditionalConstraint();
        $this->constraint->addValueCondition('type', 'url');
        $this->constraint->addValidator(new RequiredValidator(), 'url');
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
                ),
                array(
                    'type' => 'node',
                    'url' => null,
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
                ),
                1,
            ),
        );
    }

}
