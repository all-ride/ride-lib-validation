<?php

namespace ride\library\validation\filter;

use \PHPUnit_Framework_TestCase;

class LowerCaseFilterTest extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerFilter
     */
    public function testFilter($mode, $value, $expected) {
        $filter = new LowerCaseFilter(array(
            LowerCaseFilter::OPTION_MODE => $mode,
        ));

        $result = $filter->filter($value);

        $this->assertEquals($expected, $result, $value);
    }

    public function providerFilter() {
        return array(
            array('normal', 'My CamelCase Sentence', 'my camelcase sentence'),
            array('first', 'My CamelCase Sentence', 'my CamelCase Sentence'),
        );
    }

}