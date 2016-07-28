<?php

namespace ride\library\validation\constraint;

use ride\library\validation\exception\ValidationException;
use ride\library\validation\filter\SafeStringFilter;
use ride\library\validation\filter\TrimFilter;
use ride\library\validation\validator\RequiredValidator;

use \PHPUnit_Framework_TestCase;

class GenericConstraintTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $trimFilter = new TrimFilter();
        $safeStringFilter = new SafeStringFilter();
        $requiredValidator = new RequiredValidator();

        $this->constraint = new GenericConstraint();
        $this->constraint->addFilter($trimFilter, 'name');
        $this->constraint->addFilter($trimFilter, 'description');
        $this->constraint->addFilter($trimFilter, 'slug');
        $this->constraint->addFilter($safeStringFilter, 'slug');

        $this->constraint->addValidator($requiredValidator, 'name');
        $this->constraint->addValidator($requiredValidator, 'slug');
    }

    /**
     * @dataProvider providerConstrain
     */
    public function testConstrain($expected, $instance) {
        $result = $this->constraint->constrain($instance);

        $this->assertEquals($expected, $result);
    }

    public function providerConstrain() {
        return array(
            array(
                array(
                    'name' => 'My Title',
                    'description' => null,
                    'slug' => 'my-title',
                ),
                array(
                    'name' => ' My Title ',
                    'description' => null,
                    'slug' => 'My Title  ',
                ),
            ),
            array(
                array(
                    'name' => 'My Title',
                    'description' => 'My description',
                    'slug' => 'my-title',
                ),
                array(
                    'name' => ' My Title ',
                    'description' => '  My description  ',
                    'slug' => 'My Title  ',
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
                    'name' => null,
                    'slug' => null,
                ),
                2,
            ),
            array(
                array(
                    'name' => ' My Title ',
                ),
                1,
            ),
        );
    }

}
