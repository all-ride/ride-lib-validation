<?php

namespace pallo\library\validation\validator;

use \PHPUnit_Framework_TestCase;

class ClassValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $test, $options) {
        $validator = new ClassValidator($options);

        $this->assertEquals($expected, $validator->isValid($test));
    }

    public function providerIsValid() {
        return array(
            array(false, 'invalid class name', array()),
            array(true, '', array(ClassValidator::OPTION_REQUIRED => 0)),
            array(false, '', array(ClassValidator::OPTION_REQUIRED => 1)),
            array(true, 'pallo\\library\\validation\\validator\\ClassValidatorTest', array()),
            array(true, 'pallo\\library\\validation\\validator\\ClassValidator', array(ClassValidator::OPTION_CLASS => 'pallo\\library\validation\\validator\\Validator')),
            array(false, 'pallo\\library\\validation\\validator\\ClassValidatorTest', array(ClassValidator::OPTION_CLASS => 'pallo\\library\validation\\validator\\Validator')),
            array(true, 'pallo\\library\\validation\\validator\\WebsiteValidator', array(ClassValidator::OPTION_CLASS => 'pallo\\library\validation\\validator\\RegexValidator')),
        );
    }

}