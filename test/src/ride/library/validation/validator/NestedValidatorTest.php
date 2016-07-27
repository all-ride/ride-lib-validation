<?php

namespace ride\library\validation\validator;

use \PHPUnit_Framework_TestCase;

class NestedValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $test) {
        $validator = new NestedValidator();
        $validator->addValidator(new RequiredValidator());
        $validator->addValidator(new NumericValidator());

        $this->assertEquals($expected, $validator->isValid($test));
    }

    public function providerIsValid() {
        return array(
            array(true, '9'),
            array(false, 'string'),
            array(false, null),
        );
    }

}
