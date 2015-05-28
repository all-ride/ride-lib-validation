<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class AllowCharacterFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($characters, $value, $expected) {
        $filter = new AllowCharacterFilter(array(
            AllowCharacterFilter::OPTION_CHARACTERS => $characters,
        ));

        $result = $filter->filter($value);

        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array('0123456789', 'Hello how are my 2 camels, 3 chickens and 1 duck', '231'),
            array('abcdefghijklmnopqrstuvwxyz', 'My CamelCase Sentence', 'yamelaseentence'),
        );
    }

}
