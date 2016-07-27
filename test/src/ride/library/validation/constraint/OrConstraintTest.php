<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\RequiredValidator;

use \PHPUnit_Framework_TestCase;

class OrConstraintTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->constraint = new OrConstraint();
        $this->constraint->addProperty('node');
        $this->constraint->addProperty('url');
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
                    'node' => 'my node',
                    'url' => null,
                ),
            ),
            array(
                array(
                    'node' => 'my node',
                    'url' => '',
                ),
            ),
            array(
                array(
                    'node' => '',
                    'url' => 'http://yoursite.com',
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
                    'node' => null,
                    'url' => null,
                ),
                2,
            ),
            array(
                array(
                    'node' => '',
                    'url' => '',
                ),
                2,
            ),
        );
    }

}
