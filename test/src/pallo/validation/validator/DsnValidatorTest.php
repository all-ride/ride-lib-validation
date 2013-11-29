<?php

namespace pallo\library\validation\validator;

use \PHPUnit_Framework_TestCase;

class DsnValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $test) {
        $validator = new DsnValidator();

        $this->assertEquals($expected, $validator->isValid($test));
    }

    public function providerIsValid() {
        return array(
            array(true, 'mysql://localhost/database'),
            array(true, 'mysql://username:password@localhost:3306/database'),
            array(false, 'mysql://username:password@localhost:3306//database'),
            array(false, 'mysql://username:password@localhost:3306'),
            array(false, 'mysql://username:password@localhost:3306/'),
            array(false, 'www.google.com'),
            array(true, 'sqlite://tmp/file.db'),
            array(true, 'sqlite:///var/lib/sqlite/file.db'),
        );
    }

}