<?php

namespace ride\library\validation\validator;

use ride\library\validation\ValidationError;

use \PHPUnit_Framework_TestCase;

class WebsiteValidatorTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerIsValid
     */
    public function testIsValid($expected, $value) {
        $validator = new WebsiteValidator();

        $result = $validator->isValid($value);
        $this->assertEquals($expected, $result, $value);

        if (!$expected) {
            $regex = $validator->getRegex();

            $expectedParameters = array(
                'value' => $value,
                'regex' => $regex
            );

            $expectedError = new ValidationError(WebsiteValidator::CODE, WebsiteValidator::MESSAGE, $expectedParameters);

            $resultErrors = $validator->getErrors();

            $this->assertEquals(array($expectedError), $resultErrors);
        }
    }

    public function providerIsValid() {
        return array(
           array(true, 'http://www.deconation.be/vintage-tafellamp-retro-vintage-bolvoet-groen-mat.html#.VQ73vlz5UVc'),
           array(true, 'http://www.annaandjack.be/#!geboorte/c1myr'),
           array(true, 'http://www.google.com'),
           array(false, 'www.google.com'),
       );
    }

}
