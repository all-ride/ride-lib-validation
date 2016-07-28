<?php

namespace ride\library\validation\validator;

use ride\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class FileExtensionValidatorTest extends PHPUnit_Framework_TestCase  {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value, $extensions, $required = true, $errorCode = FileExtensionValidator::CODE, $errorMessage = FileExtensionValidator::MESSAGE) {
        $validator = new FileExtensionValidator($this->getArguments($extensions, $required));

        $this->assertEquals($expected, $validator->isValid($value));
    }

    public function providerIsValid() {
        return array(
           array(true, 'test.txt', null),
           array(false, 'test', null),
           array(true, '', null, false),
           array(false, '', null, true, RequiredValidator::CODE, RequiredValidator::MESSAGE),
           array(false, null, 'txt', true, RequiredValidator::CODE, RequiredValidator::MESSAGE),
           array(true, 'test.txt', 'txt'),
           array(false, 'test.txt', 'jpg'),
           array(true, 'test.txt', 'jpg,gif,txt'),
        );
    }

    private function getArguments($extensions, $required = null) {
        $arguments = array();

        if ($extensions) {
            $arguments[FileExtensionValidator::OPTION_EXTENSIONS] = $extensions;
        }

        if ($required !== null) {
            $arguments[FileExtensionValidator::OPTION_REQUIRED] = $required;
        }

        return $arguments;
    }

}